<?php
class GiftManager extends Manager
{
    
    // ========================================================
    // Ajout d'un gift
    // ========================================================
    
    public function create(Gift $gift) 
    {
        // Création et assignation du slug
        $tools = new Tools();
        $gift->setId_gift($tools->createSlug($gift->name()));
        
        // Récupération de la liste des gifts
        $gifts_list = $this->lists();
        
        // Ajout du cadeau à la liste
        $gifts_list[] = $gift;
        
        // Encodage au format JSON
        $json = json_encode($gifts_list, JSON_PRETTY_PRINT);

        // Réécriture du fichier JSON
        file_put_contents($this->_db, $json);
    }
    
    // ========================================================
    // Modification d'un gift
    // ========================================================
    
    public function update(Gift $gift)
    {   
        // Récupération du gift à modifier
        $gift_old = $this->get($gift->id_gift(),$gift->id_user());
        
        if(!$gift_old)
        {
            return false;
        }
        
        // Suppression de l'ancienne cover si elle a été modifiée
        if($gift_old->img() !== $gift->img() && $gift_old->img() !== DEFAULT_GIFT)
        {
            unlink(realpath(__DIR__ . '/..').'/'.$gift_old->img());
        }
        
        if($gift_old->name() !== $gift->name())
        {
            $tools = new Tools();
            $gift->setId_gift($tools->createSlug($gift->name()));
        }
        
        $gifts_list = $this->lists();
        
        // Suppression de l'ancien gift
        foreach($gifts_list as $key => $current_gift)
        {
            if($current_gift->id_gift() == $gift_old->id_gift())
            {
                unset($gifts_list[$key]);
            }
        }
        
        $gifts_list[] = $gift;
        
        // Encodage au format JSON
        $json = json_encode($gifts_list, JSON_PRETTY_PRINT);

        // Réécriture du fichier JSON
        file_put_contents($this->_db, $json);
    }
    
    // ========================================================
    // Suppression d'un gift
    // ========================================================
    
    public function delete($id) 
    {
        
        $gifts_list = $this->lists();
        $id_user = $_SESSION['user']->id_user();
        $gift = $this->get($id,$_SESSION['user']->id_user());
        
        // Envoi d'une notification par email si le cadeau était réservé
        if($gift->booked())
        {
            $manager = new UserManager(DB_USERS);
            $user = $manager->get($gift->booked());
            $owner = $manager->get($gift->id_user());
            
            $email_address = $user->email();
            $email_link = SITE_MAIN_BASE.'liste/view/'.$owner->id_user().'/';
            $user_name = $user->username();
            $gift_name = $gift->name();
            $owner_name = $owner->username();
            $formulaire = 'gift-deleted';
        
            include(realpath(__DIR__).'/../form/form-mail-contact.php');
        }
        
        // Suppression de l'image sauf si image par défaut
        if($gift->img() && $gift->img() !== DEFAULT_GIFT)
        {
            unlink(realpath(__DIR__ . '/..').'/'.$gift->img());
        }
        
        // Suppression de l'ancien gift
        foreach($gifts_list as $key => $current_gift)
        {
            if($current_gift->id_gift() == $gift->id_gift())
            {
                unset($gifts_list[$key]);
            }
        }
        
        // Encodage au format JSON
        $json = json_encode($gifts_list, JSON_PRETTY_PRINT);

        // Réécriture du fichier JSON
        file_put_contents($this->_db, $json);
    }
    
    // ========================================================
    // Récupération d'un gift par son id
    // ========================================================
    
    public function get($id, $id_user) 
    {
        $gifts_list = $this->lists();
        
        if(empty($gifts_list))
        {
            return false;
        }
        else
        {
            foreach($gifts_list as $gift)
            {
                if($gift->id_gift() == $id && $gift->id_user() == $id_user)
                {
                    return $gift;
                }
            }
            
            return false;
        }
    }
    
    // ========================================================
    // Lister tous les gifts
    // ========================================================
    
    public function lists($id_user = false) 
    {
        $gifts = json_decode(file_get_contents($this->_db));
        
        $gifts_dates = [];
        $gifts_list = [];
        
        foreach($gifts as $gift)
        {
            $current_gift = new Gift((array) $gift);
            
            if($id_user)
            {
                if($current_gift->id_user() == $id_user)
                {
                    $gifts_list[] = $current_gift;
                    $gifts_dates[] = $current_gift->publish();
                }
            }
            else
            {
                $gifts_list[] = $current_gift;
                $gifts_dates[] = $current_gift->publish();
            }
        }
        
        if(!empty($gifts_list))
        {
            array_multisort($gifts_dates, SORT_DESC, $gifts_list);
        }
        
        return $gifts_list;
    }
}
?>