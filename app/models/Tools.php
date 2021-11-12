<?php
class Tools
{
    // ========================================================
    // Méthode pour créer une redirection
    // ========================================================
    
    public function redirect($route,$front = false) 
    {
        if(is_string($route))
        {   
            $route = ltrim($route,'/');
            if($front)
            {
                header('location:'.SITE_FRONT_BASE.$route);
                die();
            }
            header('location:'.SITE_MAIN_BASE.$route);
            die();
        }
    }
    
    // ========================================================
    // Méthode pour créer un slug à partir d'une chaine de caractères
    // ========================================================
    
    public function createSlug($chaine) 
    {
        $slug = mb_strtolower($chaine);
        $slug = htmlentities($slug);
        $slug = preg_replace('#&([A-za-z])(?:acute|grave|cedil|circ|orn|ring|slash|th|tilde|uml);#', '\1', $slug);
        $slug = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $slug);
        $slug = preg_replace('#&[^;]+;#', '', $slug);
        $slug = str_replace(' ', '-', $slug);
        $slug = str_replace(array('?','!',',','.','\'','"',':','%','(',')','°','=','#','[',']','\\','/','@','|','&','+','*','²','^','{','}'), '', $slug);
        $slug = str_replace('----', '-', $slug);
        $slug = str_replace('---', '-', $slug);
        $slug = str_replace('--', '-', $slug);
        $slug = trim($slug, '-');
        $slug = trim($slug, '-');
        $slug = strtolower($slug);
        return $slug;
    }
}
?>