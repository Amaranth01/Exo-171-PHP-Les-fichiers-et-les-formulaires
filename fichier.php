<?php

foreach ($_FILES['fichierUtilisateur'] as $key => $value) {
    echo "$key => $value <br>";
}

function getRandomName(string $regularName): string
{
    $infos = pathinfo($regularName);
    try {
        $bytes = random_bytes(10);
    } catch (Exception $e) {
        $bytes = openssl_random_pseudo_bytes(10);
    }
    return bin2hex($bytes) . '.' . $infos['extension'];
}


if (isset($_FILES['fichierUtilisateur']) && $_FILES['fichierUtilisateur']['error'] === 0) {
    $allowedMimTypes = ['test/plain', 'image/jpeg', 'image/jpg'];
    if(in_array($_FILES['fichierUtilisateur']['type'], $allowedMimTypes)) {

        $maxSize = 3 * 1024 * 1024;
        if((int)$_FILES['fichierUtilisateur']['size'] <= $maxSize) {

            $tmp_name = $_FILES['fichierUtilisateur']['tmp_name'];

            $name = getRandomName($_FILES['fichierUtilisateur']['name']);

            if(!is_dir('uploads')){
                mkdir('uploads', '0755');
            }
            move_uploaded_file($tmp_name, $name);
        }
        else{
            echo "Le poids est trio lourds, poids maximal 2Mo";
        }
    }
    else {
        echo "Mauvais type de fichier";
    }
}
else {
    echo "Une erreur est survenu pendant l'upload";
}

