<?php

require_once("model/Survey.inc.php");
require_once("model/Response.inc.php");
require_once("actions/Action.inc.php");

class AddSurveyAction extends Action
{

    /**
     * Traite les données envoyées par le formulaire d'ajout de sondage.
     *
     * Si l'utilisateur n'est pas connecté, un message lui demandant de se connecter est affiché.
     *
     * Sinon, la fonction ajoute le sondage à la base de données. Elle transforme
     * les réponses et la question à l'aide de la fonction PHP 'htmlentities' pour éviter
     * que du code exécutable ne soit inséré dans la base de données et affiché par la suite.
     *
     * Un des messages suivants doivent être affichés à l'utilisateur :
     * - "La question est obligatoire.";
     * - "Il faut saisir au moins 2 réponses.";
     * - "Merci, nous avons ajouté votre sondage.".
     *
     * Le visiteur est finalement envoyé vers le formulaire d'ajout de sondage en cas d'erreur
     * ou vers une vue affichant le message "Merci, nous avons ajouté votre sondage.".
     *
     * @see Action::run()
     */
    public function run()
    {
        /* TODO START */
        $question = $_POST['questionSurvey'];

        $q = 0;
        for ($i = 1; $i <= 5; $i++) {
            $reponse = $_POST['responseSurvey' . '$i'];
            if (isset($reponse) === true) {
                $q++;
            }
        }

        if (isset($question) === false) {
            $this->setAddSurveyFormView("La question est obligatoire.");
        } elseif ($q < 3) {
            $this->setAddSurveyFormView("Il faut saisir au moins 3 réponses.");
        } else {
            $survey = [$this->getSessionLogin(), $question];;
            for ($i = 1; $i <= 5; $i++) {
                if (isset($_POST['responseSurvey' . '$i']) === true) {
                    $rep = $_POST['responseSurvey' . '$i'];
                    saveResponse($rep);
                }

                saveSurvey($survey);
            }
        }


        /* TODO END */
    }

    private function setAddSurveyFormView($message)
    {
        $this->setView(getViewByName("AddSurveyForm"));
        $this->getView()->setMessage($message, "alert-error");
    }

}

?>
