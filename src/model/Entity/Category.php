<?php


namespace App\model\Entity;


class Category
{

    private $id_category;
    private $name_category;
    private $icone;

    /**
     * @return mixed
     */
    public function getIdCategory()
    {
        return $this->id_category;
    }

    /**
     * @param mixed $id_category
     * @return Category
     */
    public function setIdCategory($id_category)
    {
        $this->id_category = $id_category;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNameCategory()
    {
        return $this->name_category;
    }

    /**
     * @param mixed $name_category
     * @return Category
     */
    public function setNameCategory($name_category)
    {
        $this->name_category = $name_category;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIcone()
    {
        return $this->icone;
    }

    /**
     * @param mixed $icone
     * @return Category
     */
    public function setIcone($icone)
    {
        $this->icone = $icone;
        return $this;
    }


}