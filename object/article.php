<?php

class article
{
    private $titre, $lattitude,$longitude,$photo,$commentaires,$contenu, $date, $id, $categorie, $auteur;
    private $bdd;

    public function __construct($id)
    {
        try{
            $this->bdd = new PDO('mysql:host=localhost;dbname=web-trotter', 'root', '');
        }
        catch(Exception $e){
            die('Erreur : '.$e->getMessage()); // on arrête tous les processus et on affiche le message d'erreur
        }

        $req = $this->bdd->prepare('SELECT * FROM articles WHERE id = :id');
        $req->execute(array('id'=> $id));

        $article = $req->fetch();
        $this->titre = $article['titre'];
        $this->contenu = $article['description'];
        $this->date = $article['dateA'];
        $this->photo = $article['photo'];
        $this->lattitude = $article['lattitude'];
        $this->longitude = $article['longitude'];
        $this->id = $id;
        $this->categorie = $article['categorie'];

        $req = $this->bdd->prepare('SELECT auteur_id as id FROM articles WHERE id = :id');
        $req->execute(array('id' => $this->id));
        $data = $req->fetch();
        $id_auteur = $data['id'];

        $req = $this->bdd->prepare('SELECT mail FROM users WHERE id = :id');
        $req->execute(array('id' => $id_auteur));
        $data = $req->fetch();
        $this->auteur = $data['mail'];


        $req = $this->bdd->prepare('SELECT * FROM commentaires WHERE article_id = :id');
        $req->execute(array('id'=> $id));

        $this->commentaires = array();
        while($commentaire = $req->fetch()){
            $this->commentaires[$commentaire['id']] = $commentaire['date']."  @".$commentaire['texte'];
        }
    }

    public function getTitre(){
        return $this->titre;
    }
    public function getLattitude(){
        return $this->lattitude;
    }
    public function getLongitude(){
        return $this->longitude;
    }
    public function getId(){
        return $this->id;
    }
    public function  getPhoto(){
        return $this->photo;
    }
    public function getCommentaires(){
        return $this->commentaires;
    }
    public function getContenu(){
        return $this->contenu;
    }
    public function getDate(){
        return $this->date;
    }
    public function getCategorie(){
       return $this->categorie;
    }
    public function getAuteur(){
        return $this->auteur;
    }
    public function isLikedC($id_com,$user_id){
        $req = $this->bdd->prepare('SELECT COUNT(*) as total FROM likecom WHERE commentaire_id = :commentaire_id AND auteur_id = :auteur_id');
        $req->execute(array('commentaire_id'=>$id_com, 'auteur_id'=>$user_id));
        $nb = $req->fetch();
        return ($nb['total'] == 1);

    }
    public function getLike() {
        $req = $this->bdd->prepare('SELECT COUNT(*) as total FROM likearticle WHERE article_id = :article_id');
        $req->execute(array('article_id'=>$this->id));
        $nb = $req->fetch();
        return $nb['total'];
    }
    public function getDislike(){
        $req = $this->bdd->prepare('SELECT COUNT(*) as total FROM dislikearticle WHERE article_id = :article_id');
        $req->execute(array('article_id'=>$this->id));
        $nb = $req->fetch();
        return $nb['total'];
    }
    public function getUniqueCommentaire(){
        $req = $this->bdd->prepare('SELECT * FROM commentaires WHERE article_id = :id ORDER BY id DESC');
        $req->execute(array('id'=> $this->id));
        $data = $req->fetch();
        return $data['texte'];
    }
    public function getNbLikeCommentaire($id_commentaire){
        $req = $this->bdd->prepare('SELECT COUNT(*) as total FROM likecom WHERE commentaire_id = :commentaire_id');
        $req->execute(array('commentaire_id'=>$id_commentaire));
        $nb = $req->fetch();
        return $nb['total'];
    }
    public function isLiked($user_id){
        $req = $this->bdd->prepare('SELECT COUNT(*) as total FROM likearticle WHERE article_id = :article_id AND auteur_id = :auteur_id');
        $req->execute(array('article_id'=>$this->id, 'auteur_id'=>$user_id));
        $nb = $req->fetch();
        return ($nb['total'] == 1);
    }

    public function isDisliked($user_id){
        $req = $this->bdd->prepare('SELECT COUNT(*) as total FROM dislikearticle WHERE article_id = :article_id AND auteur_id = :auteur_id');
        $req->execute(array('article_id'=>$this->id, 'auteur_id'=>$user_id));
        $nb = $req->fetch();
        return ($nb['total'] == 1);
    }

    public function isSignaled($user_id){
        $req = $this->bdd->prepare('SELECT COUNT(*) as total FROM signalement WHERE article_id = :article_id AND auteur_id = :auteur_id');
        $req->execute(array('article_id'=>$this->id, 'auteur_id'=>$user_id));
        $nb = $req->fetch();
        return ($nb['total'] == 1);
    }
}