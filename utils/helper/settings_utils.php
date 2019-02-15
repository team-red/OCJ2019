<?php

    class UserParameters
    {

        public static function createChangePhotoForm($login){
            $src = User::getPhotoSource($login);
            echo <<<flag
            <div class='change_pdp row'>
            <div class='col-md-2'><img src='$src' alt='Photo de profil' style='max-width: 100%'/></div>
            <form method="post" enctype="multipart/form-data" class="col-md-10">
                Choisissez une photo de profil <br> (verifiez bien qu'elle est de type .jpg et ne dépasse pas 500Kb):
                <br><br><input type="file" name="pdp" id="pdp" required>
                <br><br><br>
                <button type="submit" class="btn btn-primary">Valider</button>
                <input type="text" name="action" value="change_photo" style="visibility: hidden;">
            </form>
            </div>
flag;
        }

        public static function createChangeInfoForm($user){
            echo <<<flag
            <form class="form settings_form" method="post">
flag;
            $name = htmlspecialchars($user->name);
            $surname = htmlspecialchars($user->surname);
            $school = htmlspecialchars($user->school);
            $city = htmlspecialchars($user->city);
            $address = htmlspecialchars($user->address);
            $grade = htmlspecialchars($user->grade);
            $birthday = htmlspecialchars($user->birthday);
            echo <<<flag
                <h1>Modifier mes données</h1>
                <br>
                <div>
                    <label for="name">Prénom</label>
                    <input type="text" id="name" class="form-control" name="name" value="{$name}" required>
                </div>

                <br>
                <div>
                    <label for="surname">Nom</label>
                    <input type="text" id="surname" class="form-control" name="surname" value="{$surname}" required>
                </div>

                <br>
                <div>
                    <label for="pwd">Nouveau mot de passe</label>
                    <input type="password" id="pwd" class="form-control" name="pwd" value="">
                </div>

                <br>
                <div>
                    <label for="pwd_conf">Retapez le mot de passe</label>
                    <input type="password" id="pwd_conf" class="form-control" name="pwd_conf" value="">
                </div>

                <br>
                <div>
                    <label for="school">Etablissement</label>
                    <input type="text" id="school" class="form-control" name="school" value="{$school}">
                </div>

                <br>
                <div>
                    <label for="city">Ville</label>
                    <input type="text" id="city" class="form-control" name="city" value="{$city}">
                </div>

                <br>
                <div>
                    <label for="address">Adresse</label>
                    <input type="text" id="address" class="form-control" name="address" value="{$address}">
                </div>

                <br>
                <div>
                    <label for="grade">Niveau scolaire</label>
                    <input type="text" id="grade" class="form-control" name="grade" value="{$grade}">
                </div>

                <br>
                <div>
                    <label for="birthday">Date de naissance</label>
                    <input type="date" id="birthday" class="form-control" name="birthday" value="{$birthday}" required>
                </div>

                <br>
                <input type="text" style="visibility: hidden;" name="action" value="modify_data">

                <div>
                    <button type="submit" class="btn btn-primary">Confirmer les changements</button>
                </div>

flag;

            echo <<<flag
            </form>
flag;
        }

        public static function createDeleteAccountForm(){
            echo <<<flag
            <form class="form delete_account_form" method="post" onsubmit="return confirm('Êtes-vous sûrs?');">
                <button type="submit" class="btn btn-danger" id="delete_account">Supprimer mon compte</button>
                <input type="text" style="visibility: hidden;" name="action" value="delete_account">
            </form>
flag;
        }
    }

?>
