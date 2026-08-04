<?php
    include_once __DIR__ . "/../classes/class.php";

#regiao---------------funçoes-------------------#


    function salvarAtletaCSV($athlete) {

    $file = fopen("../data/DataAthlete.csv", "a");

    fputcsv($file, [
        $athlete->ID,
        $athlete->name,
        $athlete->age,
        $athlete->birth,
        $athlete->sport,
        $athlete->position,
        $athlete->paid ? 'true' : 'false'
    ]);

    fclose($file);
}


#fim regiao

#regiao --> certificação de que todas as variaveis chegaram do post


    if (isset($_POST['name'], $_POST['birth'], $_POST['sport'],$_POST['position'])) {

        $name = $_POST['name'];
        $birth = $_POST['birth'];
        $sport = $_POST['sport'];
        $position = $_POST['position'];
        $paid = isset($_POST['paid']) && $_POST['paid'] === 'true';


#fimregiao
#regiao

        $arquivo = "../data/DataAthlete.csv";

        if (!file_exists($arquivo)) {
            die("CSV não encontrado!");
        }

        $dados = file($arquivo);
        $maior = 0;

        foreach ($dados as $linha) {
            $dadosLinha = explode(",", trim($linha));
            $primeiroCampo = trim($dadosLinha[0] ?? '');

            if ($primeiroCampo !== 'id' && is_numeric($primeiroCampo)) {
                if ((int)$primeiroCampo > $maior) {
                    $maior = (int)$primeiroCampo;
                }
            }
        }
    
        $id = $maior + 1;

#fim da regiao
#regiao --> criar novo atleta


        if ($sport === "volei") {
            $athlete = new AtletaVolei($id, $name, $birth, $sport, $position, $paid);
        } else {
            header("Location: ../../frontend/home.php?error=2");
            exit;
        }

        if (isset($athlete)) {
            salvarAtletaCSV($athlete);
        }

        
#fim regiao
#regiao --> devolver o usuraio ao site


    } else {
        header("Location: ../../frontend/home.php?error=1");
        exit;
    }
    header("Location: ../../frontend/home.php");
        exit;

#fim regiao
?>