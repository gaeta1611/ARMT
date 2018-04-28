<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Registration Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during registration of a new user.
    |
    */

    'set_role_admin_to_employee_forbidden' => "Un administrateur ne peut pas devenir employé! Le rôle n'a pas été modifié",
    'record_saved' => "L'utilisateur a bien été enregistré",
    'error_saving' => "Une erreur s'est produite lors de l'enregristrement!",
    'add_record' => "Ajouter :record",
    'user' => "utilisateur|utilisateurs",
    'user_profile' => "Profil Utilisateur",
    'save' => "Enregistrer",
    'cancel' => "Annuler",
    'record_list' => "Liste des :record",
    'created_at' => 'Date de création',
    'delete' => 'Supprimer',
    'delete_confirmation' => 'Etes vous sur de vouloir supprimer :pronoun :record ?',
    'delete_record' => 'Supprimer :record',
    'pronouns' => [
        'this' => '{1}ce|{2}cet|{3}cette',
        'that' => 'ce|cet|cette',
        'these' => 'ces',
        'those' => 'those',
    ],
    'no_record' => 'Aucun :record',
    'edit' => 'Modifier',
    'home' => 'Accueil',
    'client' => 'client|clients',
    'prospect' => 'prospect|prospects',
    'search' => 'Rechercher',
    'clear_all' => 'Effacer tout',
    'add' => 'Ajouter',
    'candidate' => 'candidat|candidats',
    'mission' => 'mission|missions',
    'list' => 'Liste',
    'date' => 'date',
    'all' => 'Tous',
    'treat' => 'A traiter',
    'to_contact' => 'A contacter',
    'to_validate' => 'A valider',
    'titles' => [
        'list_client_prospect'=> "Liste des Clients & Prospects ",
        'list_mission'=> "Liste des Missions ",
        'add_client_prospect'=> "Ajouter un client ou prospect ",
        'add_mission'=> "Ajouter une mission ",
        'add_candidate' => 'Ajouter candidat',
        'add_candidacy' => 'Ajouter candidature',
        'search_candidate' => 'Recherche de candidats',
        'add_a_mission' => 'Ajouter à la mission',
        'add_candidacy' => 'Ajouter une candidature',
        'edit_candidate' => 'Modifier candidat',
        'edit_mission' => 'Modifier la mission',
    ],
    'logout' => 'Déconnexion',
    'function' => 'fonction|fonctions',
    'contract' => 'contrat|contrats',
    'status' => 'Statut',
    'notice' => 'Remarque',
    'type' => 'Type',
    'company_name' => 'Nom entreprise',
    'vat' => 'TVA',
    'contact_person' => 'Personne de contact',
    'phone' => 'Téléphone',
    'zip_code' => 'Code postal',
    'locality' => 'Localité',
    'address' => 'Adresse',
    'website' => 'Site internet',
    'linkedin' => 'Linkedin',
    'reference' => 'Référence',
    'contract_type' => 'Type de contrat',
    'job_description' => 'descriptions de job',
    'offer' => 'offres',
    'candidate' => 'Candidat',    
    'degree' => 'Diplôme',
    'employer' => 'Employeur',
    'advancement' => 'Avancement',
    'response_mode' => 'Mode réponse',
    'response_date' => 'Date réponse',
    'date_f2f' => 'Date 1er F2F',
    'date_candidate_client' => 'Date candidat vs client',
    'date_3_interview' => 'Date 3e interview',
    'media' => 'Média',
    'interview_rapport' => "Rapport d'interview",
    'no_candidate_mission' => "Aucun candidat pour cette mission.",
    'birth_date' => 'Date de naissance',
    'sex' => 'Sexe',
    'last_employer' => 'Dernier Employeur',
    'last_function' => 'Dernière Fonction',
    'employer_function' => 'Employeurs/Fonctions',
    'function_exercised' => 'Fonction exercée',
    'employer_management' => 'Gestion des Employeurs',
    'load_cv' => 'Chargez le/les CV',
    'load_cl' => 'Chargez la lettre de motivation',
    'load_interview_rapport' => 'Chargez le rapport d\'interview',
    'load_contract' => 'Chargez le contrat',
    'load_job_description' => 'Chargez le/les descriptions de job',
    'load_offer' => 'Chargez le/les offres',
    'employer_management_past' => 'Gestion des employeurs antérieurs & actuels',
    'list_employer_top' => 'Veuillez placer le dernier employeur en tête de liste',
    'start_date' => 'Date de début',
    'end_date' => 'Date de fin',
    'close' => 'Fermer',
    'save_and_close' => 'Sauvergarder & Fermer',
    'cancel_change' => 'Annuler les modifications',
    'new_degree' => 'Nouveau diplôme',
    'required_fields' => 'Champs obligatoires',
    'finality' => 'Finalité',
    'level' => 'Niveau',
    'school' => 'Ecole',
    'diploma_code' => 'Code diplôme',
    'language_level' => '{1}Nihil|{2}Notions|{3}Bases|{4}Courant|{5}Maîtrise|{6}Maternelle',
    'other' => 'Other',
    'cv' => 'CV',
    'postuled' => 'A postulé',
    'cover_letter' => 'Lettre de motivation',
    'cl' => 'LM',
    'match' => 'Correspond',
    'mail' => 'mail',
    'age' => 'Age',
    'filter' => 'Filtrer',
    'candidacy_mode' => 'Mode candidature',
    'none' => 'Aucun',
    'mission_status' => 'Status de la mission',
    'description' => 'Description',

    'error_lastname' => "Veuillez entrer le nom du candidat",
    'error_lastname_caractere' => "Le nom du candidat ne peut pas dépasser 60 caractères",
    'error_firstname' => "Veuillez entrer le prénom du candidat",
    'error_firsname_caractere' => "Le prénom du candidat ne peut pas dépasser 60 caractères",
    'error_sex' => "Veuillez entrer le sexe du candidat",
    'error_sex_m_f' => "Veuillez renseigner m ou f pour le sexe du candidat",
    'error_email' => "Veuillez entrer un email",
    'error_type_email' => "Type de valeur incorrecte pour l'email",
    'error_exist_email' => "L'adresse mail existe déjà",
    'error_email_caractere' => "L'email ne peut pas dépasser 120 caractères",
    'error_type_localite' => "Type de valeur incorrecte pour la localité!",
    'error_zip_caractere' => "Le code postal ne peut dépasser 10 caractères.",
    'error_localite_caractere' => "La localité ne peut dépasser 120 caractères.",
    'error_type_birth_date' => "Type de valeur incorrecte pour la date de naissance",
    'error_phone_caractere' => "Le numéro de téléphone ne peut pas dépasser 20 caractères",
    'error_valide_linkedin' => "Veuillez entrer une URL valide pour Linkedin en ajoutant http://",
    'error_db_linkedin' => "Ce Linkedin existe déjà dans votre DB",
    'error_linkedin_caractere' => "L'URL de Linkedin ne peut pas dépasser 255 caractères",
    'error_valide_website' => "Veuillez entrer une URL valide pour le site internet en ajoutant http://",
    'error_db_website' => "Ce site internet existe déjà dans votre DB",
    'error_website_caractere' => "L'URL du site internet ne peut pas dépasser 255 caractères",
    'succes_locality' => "Une nouvelle localité a été enregistrée",
    'error_locality' => "Une erreur s'est produite lors de l'enregistrement de la localité!",
    'success_candidate_save' => "Le candidat a bien été enregistré",
    'error_language_save' => "Erreur lors de l'enregistrement d'une langue pour ce candidat!",
    'error_diploma_save' => "Erreur lors de l'enregistrement d'un diplôme pour ce candidat!",
    //'error_emploi_save' => "Une erreur s'est produite lors de l'enregistrement des emplois antérieurs $cptNotSaved! $message",
    'error_cv_save' => "Erreur lors de l'enregistrement du document (CV)!",
    'error_general' => "Une erreur s'est produite lors de l'enregistrement!",
    'error_diploma_delete' => "Erreur lors de la suppression d'un diplome pour ce candidat!",
    'error_cv_delete_disk' => "L'ancien CV n'a pas pu être supprimé du disque !",
    'error_cv_delete' => "L'ancien CV n'a pas pu être supprimé !",
    'success_candidate_delete' => "Le candidat a bien été supprimé",
    'error_candidate_delete' => "Une erreur s'est produite lors de la suppression du candidat!",
    'impossible_candidate_delete' => "Impossible de supprimer ce candidat",

    //'error_ajax_emploi' => "Erreur Ajax: $cptNotSaved emploi non sauvés!",
    'data_incomplete' => "Les donnees sont incomplete dans la requete",
    'error_emploi_delete' => "Une erreur s'est produite lors de la suppression de l'emploi!",
    'impossible_emploi_delete' => "Une erreur s'est produite lors de la suppression de l'emploi!",

    'candidacy_save' => "La candidature a bien été enregistré",
    'mission_type_incorrect' => "'Le type du champ mission_id est incorrect",
    'done_candidate' => "Veuillez spécifier le candidat",
    'incorrect_valeur_candidate' => "Valeur incorrecte pour le candidat",
    'done_date_candidacy' => "Veuillez spécifier la date de candidature",
    'create_at_type_incorrect' => "Le type du champ created_at est incorrecte",
    'postule_mission_type_incorrect' => "Le type du champ postule_mission_id est incorrect",
    'done_candidacy_mode' => "Veuillez spécifier le mode de candidature",
    'done_status' => "Veuillez spécifier le statut",
    'mode_reponse_type_incorrect' => "Le type du champ mode_reponse_id est incorrecte",
    'date_reponse_type_incorrect' => "Le type du champ date_reponse est incorrecte",
    'f2f_type_incorrect' => "Le type du champ date_F2F est incorrecte",
    'date_rencontre_client_type_incorrect' => "Le type du champ date_rencontre_client est incorrecte",
    'error_rapport_save' => "Erreur lors de l'enregistrement du document (rapport interview)!",
    'error_lettre_save' => "Erreur lors de l'enregistrement du document (lettre de motivation)!",
    'success_candidacy' => "La candidature a bien été enregistré",
    'error_rapport_delete_disk' => "L'ancien rapport d'interview n'a pas pu être supprimé du disque !",
    'error_rapport_delete' => "L'ancien rapport d'interview n'a pas pu être supprimé de la DB !",
    'error_lettre_delete_disk' => "L'ancienne lettre de motivation n'a pas pu être supprimé du disque !",
    'error_lettre_delete' => "L'ancienne lettre de motivation n'a pas pu être supprimé de la DB !",
    //'impossible_emploi_delete' => "Une erreur s'est produite lors de l'enregistrement de la candidature $candidature->id!",

    'error_company_name' => "Veuillez entrer le nom d'une entreprise",
    'error_exist_company' => "Ce nom d'entreprise existe déjà",
    'error_company_caractere' => "Le nom de l'entreprise ne peut pas dépasser 60 caractères",
    'error_person_contact_caractere' => "La personne de contact ne peut pas dépasser 100 caractères",
    'error_address_caractere' => "L'adresse ne peut pas dépasser 255 caractères",
    'error_tva_caractere' => "Le numéro de TVA ne peut pas dépasser 15 caractères",
    'error_nature_company' => "Veuillez choisir la nature de l'entreprise (prospect ou client)",
    'error_type_type' => "Type de valeur incorrecte pour le type",
    'success_client_save' => "Le client a bien été enregistré",
    'success_client_delete' => "Le client a bien été supprimé",
    'error_client_delete' => "Une erreur s'est produite lors de la suppression du client!",
    'impossible_client_delete' => "Impossible de supprimer ce client (supprimer les missions avant)!",
    
    'format_incorrect' => "Format incorrecte pour le type d'interview",
    'miss_type_interview' => "Il manque le type d'interview dans la requête",

    'error_client_name' => "Veuillez entrer le nom du client",
    'error_function_name' => "Veuillez entrer la fonction recherchée",
    'error_function_caractere' => "La fonction ne peut dépasser 80 caractères",
    'error_type_contract' => "Veuillez entrer le type de contrat",
    'error_type_incorrect' => "Le type du contrat est incorrecte",
    'error_type_status' => "Veuillez entrer le type de statut",
    'error_contract_save' => "Erreur lors de l'enregistrement du document (contrat)!",
    'success_mission_save' => "La mission a bien été enregistrée",
    'error_job_save' => "Erreur lors de l'enregistrement du document (job description)!",
    'error_offre_save' => "Erreur lors de l'enregistrement du document (offre)!",
    'error_contract_delete_disk' => "L'ancien contrat n'a pas pu être supprimé du disque !",
    'error_rapport_delete' => "L'ancien contrat n'a pas pu être supprimé de la DB !",
    'success_mission_edit' => "La mission a bien été modifiée",
    'error_job_delete_disk' => "L'ancien job description n'a pas pu être supprimé du disque !",
    'error_job_delete' => "L'ancien job description n'a pas pu être supprimé !",
    'error_offre_delete' => "L'ancienne offre n'a pas pu être supprimée !",
    'error_offre_delete_disk' => "L'ancienne offre n'a pas pu être supprimée du dsique !",
    'error_edit' => "Une erreur s'est produite lors de la modification!",
    'success_mission_delete' => "La mission a bien été supprimé",
    'success_mission_save' => "La mission a bien été enregistré",
    'error_mission_delete' => "Une erreur s'est produite lors de la suppression de la mission!",
    'impossible_mission_delete' => "Impossible de supprimer cette mission (supprimer les candidats avant)!",
    'succes_add_function' => "Une nouvelle fonction a bien été ajoutée.",
    'candidate_already_present' => "Ce candidat est déjà présent dans cette mission",
    'succes_save_candidacy' => "La candidature a bien été enregistré",

    'error_user_lastname' => "Veuillez entrer le nom",
    'error_user_lastname_caractere' => "Le nom  ne peut pas dépasser 60 caractères",
    'error_user_firsname' => "Veuillez entrer le prénom",
    'error_user_firstname_caractere' => "Le prénom peut pas dépasser 60 caractères",
    'error_initials' => "Veuillez entrer les initiales de l'utilisateur",
    'error_two_caractere_initials' => "Veuillez entrer 2 caractères pour les initiales",
    'error_initials_already_exist' => "Ces initiales existent déjà",
    'error_choice_language' => "Veuillez choisir une langue préférée",
    'error_language_caractere' => "Le choix de la langue ne peut pas dépasser 2 caractères",
    'error_login' => "Veuillez entrer le login",
    'error_login_caractere' => "Le login ne peut pas dépasser 20 caractères",
    'error_login_already_exist' => "Ce login existent déjà",
    'error_password' => "Veuillez entrer un mot de passe",
    'error_password_caractere' => "Le mot de passe doit comporter au moins 6 caractères",
    'error_password_confirmed' => "Veuillez confirmer le mot de passe",
    'succes_save_user' => "L'utilisateur a bien été enregistré",
    'succes_delete_user' => "L'utilisateur a bien été supprimé",
    'error_general_delete' => "Une erreur s'est produite lors de la suppression!",
    'impossible_user_delete' => "Impossible de supprimer cet utilisateur",
    'impossible_user_connected_delete' => "Impossible de supprimer l'utilisateur connecté",
    
  
    
    
    
    
    

    

    
    

   

    
    

    
    

    
    
    
    
    
    
    
    
    
    
    
    
    
    
];