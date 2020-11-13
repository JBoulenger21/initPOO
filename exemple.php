<?php

class Personnage //Présence du mot-clé class suivi du nom de la classe
{
  // Déclaration des attributs et méthodes ici
  private $_force = 50; //la force du perso, par défaut 50
  private $_localisation = 'Dijon'; //Sa localisation, par défaut Dijon
  private $_experience = 1; //Son expérience, par défaut 1
  private $_degats = 0; //Ses dégâts, par défaut 0

//Constante en rapport à la force. Pas de $ !

  const FORCE_PETITE = 20;
  const FORCE_MOYENNE = 50;
  const FORCE_GRANDE = 80;

//Variable static privée. Ici $ !

private static $_texteADire = 'Je vais tous vous tuer !<br/>';

//constructeur
  public function __construct($forceInitiale, $degats)
  {
    echo 'Voici le constructeur !<br/>';
    $this->setForce($forceInitiale);
    $this->setDegats($degats);
  }


//Les getters :
  public function experience() //Une méthode pour afficher l'expérience du personnage
  {
    return $this->_experience;
  }

  public function force()
  {
    return $this->_force;
  }

  public function degats()
  {
    return $this->_degats;
  }

  public function localisation()
  {
    return $this->_localisation;
  }

  //Les setters:
  public function setForce($force)
  {
  //   if (!is_int($force)){
  //     trigger_error('La force d\'un personnage ne peut dépasser 100', E_USER_WARNING);
  //     return;
  //   }
  //   if($force>100){
  //     trigger_error('Laforce d\'un personnage ne peut dépasser 100', E_USER_WARNING);
  //     return;
  //   }
  //   $this->_force = $force;
  if (in_array($force, [self::FORCE_PETITE, self::FORCE_MOYENNE, self::FORCE_GRANDE])){
    $this->_force = $force;
  }
  }

  public function setExperience($experience)
  {
    if(!is_int($experience)){
      trigger_error('L\'expérience d\'un personnage doit être un nombre entier', E_USER_WARNING);
      return;
    }
    if($experience>100){
      trigger_error('L\'expérience d\'un personnage ne peut pas dépasser 100', E_USER_WARNING);
      return;
    }
    $this->_experience = $experience;
  }

  public function setDegats($degats)
  {
    if (!is_int($degats))
    {
      trigger_error('Le niveau de dégâts d\'un personnage doit être un nombre entier', E_USER_WARNING);
      return;
    }

    $this->_degats = $degats;
  }


  // public function deplacer() //Une méthode qui déplacera le personnage, modifiera sa localisation
  // {
  //   $this->_localisation++;
  // }
  public function frapper(Personnage $persoAFrapper) //Une méthode qui frappera un personnage (suivant la force qu'il a)
  {
    $persoAFrapper->_degats += $this->_force;
  }
  public function gagnerExperience() //Une méthode augmentant l'attribut expérience du personnage
  {
    //Cette méthode doit ajouter 1 à l'expérience du personnage.
    $this->_experience++;
  }

  // Notez que le mot-clé static peut être placé avant la visibilité de la méthode (ici c'est public).
  public static function parler()
  {
    echo self::$_texteADire;
  }
}

// Ici, on crée des objets de personnage
$perso1 = new Personnage(Personnage::FORCE_MOYENNE,0);
$perso2 = new Personnage(Personnage::FORCE_GRANDE,10);
Personnage::parler();


//On veut que le personnage 1 tape le personnage 2 gagne de l'expérience, et l'inverse ensuite
$perso1->frapper($perso2);
$perso1->gagnerExperience();

$perso2->frapper($perso1);
$perso2->gagnerExperience();

echo 'Le personnage 1 a ', $perso1->force(), ' de force, contrairement au personnage 2 qui a ', $perso2->force(),' de force.<br/>';
echo 'Le personnage 1 a ', $perso1->experience(), ' d\'expérience, contrairement au personnage 2 qui a ', $perso2->experience(), ' d\'expérience.<br/>';
echo 'Le personnage 1 a ', $perso1->degats(), ' de dégâts, contrairement au personnage 2 qui a ', $perso2->degats(), ' de dégâts.</br>';

// La class compteur qui ne sert à rien :

class Compteur{
  //L'attribut lié à la classe
  private static $_compteur=0;
  //Le constructeur
  public function __construct(){
    self::$_compteur++;
  }
  public static function getCompteur(){
    return self::$_compteur;
  }
}

$test1 = new Compteur;
$test2 = new Compteur;
$test3 = new Compteur;
$test4 = new Compteur;
$test5 = new Compteur;

echo Compteur::getCompteur(),' : ceci est le nombre de compteurs.<br/>';

?>
