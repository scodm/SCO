<?php

require_once "MyDB/MyDB.php";	

// die();	

MyDB::createTable("user")->integer("NIdUser", array("pk"=> true, "ai"=> true))
						 ->varchar("SNomUser")
						 // ->varchar("SPrenomUser")
						 ->varchar("SEmailUser")
						 ->varchar("SPProfilUser")
						 ->exec();
die();						 
MyDB::createTable("equipe")->integer("NIdEquipe", array("pk"=>true, "ai"=> true))
						   ->integer("NIdUser", array("fk"=> true, "tableName"=>"user"))
						   ->varchar("SNomEquipe")
						   ->datetime("DDateEquipe")
						   ->bool("DeleteEquipe")
						   ->exec();
						   
MyDB::createTable("user_equipe")->integer("NIdUser, NIdEquipe", array("pk"=> true))
								->date("DDate")
								->exec();
						 
MyDB::createTable("client")->integer("NIdClient", array("pk"=> true, "ai"=> true))
						 ->varchar("SNomClient")
						 ->varchar("SPrenomClient")
						 ->varchar("SDesignationClient")
						 ->varchar("SEmailClient")
						 ->datetime("DDateClient")	
						 ->exec();
						 
MyDB::createTable("projet")->integer("NIdProjet", array("pk"=> true, "ai"=> true))
						 ->integer("NIdUser", array("fk"=> true, "tableName"=>"user"))
						 ->integer("NIdClient", array("fk"=> true, "tableName"=>"client"))
						 ->integer("NIdEquipe", array("fk"=> true, "tableName"=>"equipe"))
						 ->varchar("SNomProjet")
						 ->varchar("SDescriptionProjet")
						 ->enum("EStatusProjet")
						 ->datetime("DDateProjet")
						 ->bool("BDeleteProjet")
						 ->exec();						
						 
MyDB::createTable("cdc")->integer("NIdCdc", array("pk"=> true, "ai"=> true))
						 ->integer("NIdProjet", array("fk"=> true, "tableName"=>"projet"))
						 ->varchar("SNomCdc")
						 ->varchar("SDescriptionCdc")
						 ->datetime("DDateCdc")
						 ->bool("EDeleteCdc")
						 ->exec();	
						 
MyDB::createTable("minicdc")->integer("NIdMiniCdc", array("pk"=> true, "ai"=> true))
						 ->integer("NIdCdc", array("fk"=> true, "tableName"=> "cdc"))
						 ->varchar("SNomMiniCdc")
						 ->varchar("SDescriptionMiniCdc")
						 ->enum("EStatusMiniCdc")
						 ->datetime("DDateMiniCdc")
						 ->bool("BDeleteMiniCdc")	
						 ->exec();
						 
MyDB::createTable("tache")->integer("NIdTache", array("pk"=> true, "ai"=> true))
						 ->integer("NIdMiniCdc", array("pk"=> true, "tableName"=> "minicdc"))
						 ->integer("NIdPColor", array("pk"=> true, "tableName"=> "priorityColor"))
						 ->integer("NIdUser", array("pk"=> true, "tableName"=> "user"))
						 ->varchar("SNomTache")
						 ->varchar("SDescriptionTache")
						 ->enum("EStatusTache")
						 ->datetime("DDateTache")
						 ->bool("BDeleteTache")	
						 ->exec();
						 
MyDB::createTable("fonctionnaliter")->integer("NIdFonctionnaliter", array("pk"=> true, "ai"=> true))
						 ->integer("NIdTache", array("fk"=> true, "tableName"=> "tache"))
						 ->integer("NIdPColor", array("pk"=> true, "tableName"=> "priorityColor"))
						 ->varchar("SNomFonctionnaliter")
						 ->varchar("SDescriptionTFonctionnaliter")
						 ->enum("EStatusFonctionnaliter")
						 ->datetime("DDateFonctionnaliter")
						 ->bool("BDeleteFonctionnaliter")	
						 ->exec();
						 
MyDB::createTable("ressource")->integer("NIdRessource", array("pk"=> true, "ai"=> true))
						 ->varchar("SNomRessource")
						 ->exec();
						 
MyDB::createTable("projet_commentaire")->integer("NIdPCommentaire", array("pk"=> true, "ai"=> true))
						 ->integer("NIdProjet", array("fk"=> true, "tableName"=>"projet"))
						 ->varchar("StextePCommentaire")
						 ->datetime("DDatePCommentaire")
						 ->exec();
						 
MyDB::createTable("minicdc_commentaire")->integer("NIdMiniCdcCommentaire", array("pk"=> true, "ai"=> true))
						 ->integer("NIdMiniCdc", array("fk"=> true, "tableName"=>"minicdc"))
						 ->varchar("StexteMiniCdcCommentaire")
						 ->datetime("DDateMiniCdcCommentaire")
						 ->exec();
						 
MyDB::createTable("fonctionnaliter_commentaire")->integer("NIdFCommentaire", array("pk"=> true, "ai"=> true))
						 ->integer("NIdFonctionnaliter", array("fk"=> true, "tableName"=> "fonctionnaliter"))
						 ->varchar("StexteFCommentaire")
						 ->datetime("DDateFCommentaire")
						 ->exec();
						 
MyDB::createTable("ressource_commentaire")->integer("NIdRessourceCommentaire", array("pk"=> true, "ai"=> true))
						 ->integer("NIdRessource", array("fk"=> true, "tableName"=>"ressource"))
						 ->varchar("StexteRessourceCommentaire")
						 ->datetime("DDateRessourceCommentaire")
						 ->exec();
						 
MyDB::createTable("priorityColor")->integer("NIdPColor", array("pk"=> true, "ai"=> true))
						 ->varchar("SCodePColor")
						 ->exec();

MyDB::createTable("notification")->integer("NIdNotification", array("pk"=> true, "ai"=> true))
						 ->integer("NIdUser", array("pk"=>true, "tableName"=>"user"))
						 ->varchar("StexteNotification")
						 ->exec();
?>