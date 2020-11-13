<?php
require('singleton.db.php');


  class Personnage{
    //attributs
    private $_id;
    private $_nom;
    private $_forcePerso;
    private $_degats;
    private $_niveau;
    private $_experience;

    //méthodes
    //le construct

    // public function __construct($nom, $forcePerso, $degats, $niveau, $experience){
    //   $this->setNom($nom);
    //   $this->setForcePerso($forcePerso);
    //   $this->setDegats($degats);
    //   $this->setNiveau($niveau);
    //   $this->setExperience($experience);
    // }

    //Les getter :
    public function id(){ return $this->_id; }
    public function nom(){ return $this->_nom; }
    public function forcePerso(){ return $this->_forcePerso; }
    public function degats(){ return $this->_degats; }
    public function niveau(){ return $this->_niveau; }
    public function experience(){ return $this->_experience; }

    //Les setters :
    public function setId($id){
      $id = (int) $id;  //Convertir l'argument en entier. Si int, rien ne change, sinon, ça donne 0.
      if ($id>0){$this->_id = $id;}
    }
    public function setNom($nom){
      if(is_string($nom)){
        $this->_nom = $nom;
      }
    }
    public function setForcePerso($forcePerso){
      $forcePerso = (int) $forcePerso;
      if($forcePerso>=1 && $forcePerso<=100){
        $this->_forcePerso = $forcePerso;
      }
    }
    public function setDegats($degats){
      $degats = (int) $degats;
      if($degats>=0 && $degats<=100){
        $this->_degats = $degats;
      }
    }
    public function setNiveau($niveau){
      $niveau = (int) $niveau;
      if ($niveau>=1 && $niveau<=100){
        $this->_niveau = $niveau;
      }
    }
    public function setExperience($experience){
      $experience = (int) $experience;
      if($experience>=1 && $experience<=100){
        $this->_experience = $experience;
      }
    }

    //Hydratation
    public function hydrate(array $donnees){
      foreach($donnees as $key => $value)
      {
        $method = 'set'.ucfirst($key);
        if (method_exists($this, $method))
        {
          $this->$method($value);
        }
      }
    }

    //constantes de classe

  }

  class PersonnagesManager{
    public function add(Personnage $perso)
    {
      $q = SPDO::getInstance()->prepare("INSERT INTO personnage(nom, forcePerso, degats, niveau, experience) VALUES (:nom, :forcePerso, :degats, :niveau, :experience)");
      $arrayValue = [
        ':nom'=>$perso->nom(),
        ':forcePerso'=>$perso->forcePerso(),
        ':degats'=>$perso->degats(),
        ':niveau'=>$perso->niveau(),
        ':experience'=>$perso->experience()
      ];
      if($q->execute($arrayValue)){
        echo "c'est cool roger !";
      }else{
        echo "Ca ne va pas roger !";
        var_dump($arrayValue);
      }
    }
    public function delete(Personnage $perso)
    {
      SPDO::getInstance()->prepare('DELETE FROM personnage WHERE id = '.$perso->id());
    }
    public function get($id)
    {
      $id = (int) $id;
      $q = SPDO::getInstance()->prepare('SELECT id, nom, forcePerso, degats, nubeau, experience FROM personnage WHERE id= '.$id);
      $q->execute();
      $donnes = $q->fetch(PDO::FETCH_ASSOC);
      return new Personnage($donnees);
    }
    public function getList()
    {
      $persos = [];
      $q = SPDO::getInstance()->prepare('SELECT id, nom, forcePerso, degats, niveau, experience FROM personnage ORDER BY nom');
      $q = execute();
      while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
      {
        $persos[] = new Personnage($donnees);
      }
      return $persos;
    }
    public function update(Personnage $perso)
    {
      $q = SPDO::getInstance()->prepare('UPDATE personnage SET forcePerso = :forcePerso, degats = :degats, niveau = :niveau, experience = :experience WHERE is = :id');

      $q->bindValue(':forcePerso', $perso->forcePerso(), PDO::PARAM_INT);
      $q->bindValue(':degats', $perso->degats(), PDO::PARAM_INT);
      $q->bindValue(':niveau', $perso->niveau(), PDO::PARAM_INT);
      $q->bindValue(':experience', $perso->experience(), PDO::PARAM_INT);
      $q->bindValue(':id', $perso->id(), PDO::PARAM_INT);
      $q->execute();
    }
  }

$aglesia = new Personnage();
$aglesia->hydrate([
  'nom' => 'Aglesia',
  'forcePerso' => 20,
  'degats' => 75,
  'niveau' => 32,
  'experience' => 99
]);
var_dump($aglesia);

$manager = new PersonnagesManager;
$manager->add($aglesia);

 ?>
