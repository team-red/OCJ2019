<?php

    class UserParameters
    {

        public static function createChangePhotoForm($login){
            $src = User::getPhotoSource($login);
            echo <<<flag
            <img src='$src' alt='Photo de profil'/>
            <form method="post" enctype="multipart/form-data">
                Choisissez une photo de profil (type .jpg):
                <input type="file" name="pdp" id="pdp" required>
                <input type="text" name="action" value="change_photo" style="visibility: hidden;">
                <input type="submit">
            </form>
flag;
        }

        public static function createChangeInfoForm($user){
            echo <<<flag
            <form class="form" method="post">
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
                <div>
                    <label for="name">Prénom</label>
                    <input type="text" id="name" class="form-control" name="name" value="{$name}" required>
                </div>

                <div>
                    <label for="surname">Nom</label>
                    <input type="text" id="surname" class="form-control" name="surname" value="{$surname}" required>
                </div>

                <div>
                    <label for="school">Etablissement</label>
                    <input type="text" id="school" class="form-control" name="school" value="{$school}">
                </div>

                <div>
                    <label for="city">Ville</label>
                    <input type="text" id="city" class="form-control" name="city" value="{$city}">
                </div>

                <div>
                    <label for="address">Adresse</label>
                    <input type="text" id="address" class="form-control" name="address" value="{$address}">
                </div>

                <div>
                    <label for="grade">Niveau scolaire</label>
                    <input type="text" id="grade" class="form-control" name="grade" value="{$grade}">
                </div>

                <div>
                    <label for="birthday">Date de naissance</label>
                    <input type="date" id="birthday" class="form-control" name="birthday" value="{$birthday}" required>
                </div>

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
            <form class="form" method="post" onsubmit="return confirm('Êtes-vous sûrs?');">
                <input type="text" style="visibility: hidden;" name="action" value="delete_account">
                <button type="submit" class="btn btn-danger" id="delete_account">Supprimer mon compte</button>
            </form>
flag;
        }
    }

?>