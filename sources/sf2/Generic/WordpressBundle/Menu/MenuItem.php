<?php

namespace Generic\WordpressBundle\Menu;

class MenuItem
{
    private $parent = null;
    private $childs = array();

    private $id = null;
    private $post_id = null;
    private $type = null;
    private $url = null;
    private $title = null;
    private $active = false;
    private $active_child = null;
    private $blank = false;
    private $css = null;

    public function __construct($menu_post)
    {
        $this->id = $menu_post->ID;
        $this->post_id = $menu_post->object_id;
        $this->type = $menu_post->object;
        $this->url = $menu_post->url;
        $this->title = $menu_post->title;

        if($menu_post->target == '_blank'){
            $this->blank = true;
        }

    }

    public function setParent(MenuItem $parent)
    {
        $this->parent = $parent;
        return $this;
    }

    public function getParent()
    {
        return $this->parent;
    }


    public function addChild(MenuItem $child)
    {
        $this->childs[] = $child;
        return $this;
    }

    public function getChilds()
    {
        return $this->childs;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getPostId()
    {
        return $this->post_id;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getActiveChild()
    {
        return $this->active_child;
    }

    public function setActiveChild(MenuItem $child)
    {
        if (!in_array($child, $this->childs, true)) {
            throw new \Exception('Cannot set non child menuitem has active child');
        }
        $this->active_child = $child;
        $this->announceActivationToParent();
    }

    public function announceActivationToParent()
    {
        if ($this->hasParent()) {
            $this->getParent()->setActiveChild($this);
        }
    }

    public function hasParent()
    {
        return $this->parent!==null;
    }

    public function setActive()
    {
        $this->active = true;
        $this->announceActivationToParent();
    }

    public function isActive()
    {
        return $this->active;
    }

    public function hasActiveChild()
    {
        return ($this->getActiveChild()!=null);
    }

    public function getBlank()
    {
        return $this->blank;
    }

    public function setCss($css){
        $this->css = $css;
        return $this;
    }

    public function getCss(){
        return $this->css;
    }
}
