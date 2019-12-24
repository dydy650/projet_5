<?php


namespace App\model;


use App\model\Entity\Category;

class CategoryManager extends DBManager
{
    public function getCategories()
    {
        $req = $this->db->query('SELECT * FROM p5_category');
        $req->setFetchMode(\PDO::FETCH_CLASS,Category::class); // Ligne necessaire pour utiliser les entitiés dans les vues
        $categories = [];
        while ($category = $req->fetch ())
        {
            $categories[] = $category;
        }
        return $categories;
    }


}