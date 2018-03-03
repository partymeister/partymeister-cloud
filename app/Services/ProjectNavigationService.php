<?php

namespace App\Services;

use App\Models\ProjectNavigation;
use Motor\Backend\Services\BaseService;

class ProjectNavigationService extends BaseService
{

    protected $model = ProjectNavigation::class;


    public function filters()
    {
        $searchFilter = $this->getFilter()->get('search');
        $model        = $this->model;
        if ( ! is_object($this->model)) {
            $model = new $this->model();
        }
        $searchFilter->setSearchableColumns($model->getSearchableColumns());
    }


    public function beforeCreate()
    {
        $this->setTreePosition();
    }


    public function beforeUpdate()
    {
        $this->setTreePosition();
    }


    public function afterCreate()
    {
        //$this->assembleSlugs();
    }


    public function afterUpdate()
    {
        //$this->assembleSlugs();
    }


    protected function setTreePosition()
    {
        // Get previous sibling (if it exists)
        $node = ProjectNavigation::find($this->request->get('previous_sibling_id'));

        // If it exists, append the item AFTER the node, but only if it has been changed
        if ( ! is_null($node)) {
            $formerPreviousSibling = null;
            if ($this->record->exists) {
                $formerPreviousSibling = $this->record->getPrevSibling();
            }
            if (( is_null($formerPreviousSibling) || ( ! is_null($formerPreviousSibling) && $formerPreviousSibling->id != $node->id ) )) {
                $this->record->scope = $node->scope;
                $this->record->afterNode($node);
            }
        }

        // Get previous sibling, if the previous sibling didn't exist
        if (is_null($node)) {
            $node = ProjectNavigation::find($this->request->get('next_sibling_id'));

            // If it exists, append the item BEFORE the node, but only if it has been changed
            if ( ! is_null($node)) {

                $formerNextSibling = null;
                if ($this->record->exists) {
                    $formerNextSibling = $this->record->getNextSibling();
                }

                if (( is_null($formerNextSibling) || ( ! is_null($formerNextSibling) && $formerNextSibling->id != $node->id ) )) {
                    $this->record->scope = $node->scope;
                    $this->record->beforeNode($node);
                }
            }
        }

        // If there is no previous or next sibling, try to check if we need to append / prepend it to the root node
        if (is_null($node)) {
            $node           = ProjectNavigation::find($this->request->get('parent_id'));
            $previousParent = $this->record->ancestors()->get()->last();
            if ( ! is_null($node) && ! is_null($previousParent) && $previousParent->id != $node->id) {
                $nextSibling = $this->record->getNextSibling();
                if (is_null($nextSibling)) {
                    $this->record->scope = $node->scope;
                    $this->record->appendToNode($node);
                } else {
                    $this->record->scope = $node->scope;
                    $this->record->prependToNode($node);
                }
            } elseif ( ! is_null($node) && is_null($previousParent)) {
                $this->record->scope = $node->scope;
                $this->record->appendToNode($node);
            }
        }

        if ( ! is_null($node)) {
            $this->record->client_id  = $node->client_id;
            $this->record->project_id = $node->project_id;
            $this->record->scope      = $node->scope;
        }
    }
}
