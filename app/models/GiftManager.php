<?php
class GiftManager extends Manager
{
    
    // ========================================================
    // Ajout d'un gift
    // ========================================================
    
    public function create(Gift $gift) 
    {
        $gifts = json_decode(file_get_contents($this->_db));
        $id_user = $_SESSION['user']->id_user();
        
        $gifts_list = $this->lists($id_user);
        $gifts_list[$gift->id_gift()] = $gift;
        
        $gifts->$id_user = $gifts_list;
        
        // Encodage au format JSON
        $json = json_encode($gifts, JSON_PRETTY_PRINT);

        // Réécriture du fichier JSON
        file_put_contents($this->_db, $json);
    }
    
    // ========================================================
    // Modification d'un gift
    // ========================================================
    
    public function update(Gift $gift, $id_user = false) 
    {
        $id_user = (!$id_user) ? $_SESSION['user']->id_user() : $id_user;
        
        // Récupération du gift à modifier
        $gift_old = $this->get($gift->id_gift(),$id_user);
        
        // Suppression de l'ancienne cover si elle a été modifiée
        if($gift_old->img() && ($gift_old->img() !== $gift->img()))
        {
            unlink(realpath(__DIR__ . '/..').'/'.$gift_old->img());
        }
        
        if($gift_old->name() !== $gift->name())
        {
            $tools = new Tools();
            $gift->setId_gift($tools->createSlug($gift->name()));
        }
        
        $gifts = json_decode(file_get_contents($this->_db));
        
        $gifts_list = $this->lists($id_user);
        unset($gifts_list[$gift->id_gift()]);
        
        $gifts_list[$gift->id_gift()] = $gift;
        
        $gifts->$id_user = $gifts_list;
        
        // Encodage au format JSON
        $json = json_encode($gifts, JSON_PRETTY_PRINT);

        // Réécriture du fichier JSON
        file_put_contents($this->_db, $json);
    }
    
    // ========================================================
    // Ajout d'un gift
    // ========================================================
    
    public function delete($id) 
    {
        $gift = $this->get($id);
        $gifts = json_decode(file_get_contents($this->_db));
        $id_user = $_SESSION['user']->id_user();
        $gifts_list = $this->lists($_SESSION['user']->id_user());
        
        // Suppression de l'ancienne cover si elle a été modifiée
        if($gift->img())
        {
            unlink(realpath(__DIR__ . '/..').'/'.$gift->img());
        }
        
        unset($gifts_list[$id]);
        
        $gifts->$id_user = $gifts_list;
        
        // Encodage au format JSON
        $json = json_encode($gifts, JSON_PRETTY_PRINT);

        // Réécriture du fichier JSON
        file_put_contents($this->_db, $json);
    }
    
    // ========================================================
    // Récupération d'un gift par son id
    // ========================================================
    
    public function get($id, $id_user = false) 
    {
        $id_user = (!$id_user) ? $_SESSION['user']->id_user() : $id_user;

        if($this->exists($id,false,$id_user))
        {
            $gifts_list = $this->lists($id_user);
            $gift = $gifts_list[$id];
        }
        
        return $gift;
    }
    
    // ========================================================
    // Vérification de l'existence d'un id
    // ========================================================
    
    public function exists($id, $update = false, $id_user = false) 
    {
        $id_user = (!$id_user) ? $_SESSION['user']->id_user() : $id_user;
        
        $gifts_list = $this->lists($id_user);
        foreach($gifts_list as $id_gift => $gift)
        {
            if($id_gift === $id)
            {
                return true;
            }
        }
        return false;
    }
    
    // ========================================================
    // Lister tous les gifts
    // ========================================================
    
    public function lists($id_user) 
    {
        $gifts_array = [];
        
        $gifts = json_decode(file_get_contents($this->_db));
        $user_gifts = '';
        
        if(isset($gifts->$id_user))
        {
            $user_gifts = $gifts->$id_user;
            
            foreach($user_gifts as $gift)
            {
                $gift_array = (array) $gift;
                $current_gift = new Gift($gift_array);
                $gifts_array[$current_gift->id_gift()] = $current_gift;
            }
        }
        
        ksort($gifts_array);
        
        return $gifts_array;
    }
}
?>