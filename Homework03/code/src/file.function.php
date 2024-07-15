<?php

// function readAllFunction(string $address) : string {
function readAllFunction(array $config) : string {
    $address = $config['storage']['address'];

    if (file_exists($address) && is_readable($address)) {
        $file = fopen($address, "rb");
        
        $contents = ''; 
    
        while (!feof($file)) {
            $contents .= fread($file, 100);
        }
        
        fclose($file);
        return $contents;
    }
    else {
        return handleError("Файл не существует");
    }
}

// function addFunction(string $address) : string {
function addFunction(array $config) : string {
    $address = $config['storage']['address'];

    $name = readline("Введите имя: ");
    $date = readline("Введите дату рождения в формате ДД-ММ-ГГГГ: ");

    if (validateName($name) && validateDate($date)) {
        $data = $name . ", " . $date . "\r\n";

        $fileHandler = fopen($address, 'a');

        if(fwrite($fileHandler, $data)){
            $result = "Запись $data добавлена в файл $address";
        }
        else {
            $result = handleError("Произошла ошибка записи. Данные не сохранены");
        }
        fclose($fileHandler);
    } else {
        $result = handleError("Некорректный ввод");
    }

    return $result;
}

// function clearFunction(string $address) : string {
function clearFunction(array $config) : string {
    $address = $config['storage']['address'];

    if (file_exists($address) && is_readable($address)) {
        $file = fopen($address, "w");
        
        fwrite($file, '');
        
        fclose($file);
        return "Файл очищен";
    }
    else {
        return handleError("Файл не существует");
    }
}

/**
 * Функция вывода сегодняшних именинников
 * @param array $config
 * @return string
 */
function birthdayToday(array $config) : string
{
    $fileContent = readAllFunction($config);
    $thisDay = date("d");
    $thisMonth = date("m");

    $dataArray = explode(PHP_EOL, substr($fileContent, 0, strlen($fileContent) - 2));
    $findBirthdays = [];

    foreach ($dataArray as $man) {
        $birthday = explode(', ', $man)[1];
        $dateArr = explode('-', $birthday);
        if ($dateArr[0] === $thisDay && $dateArr[1] === $thisMonth)
            $findBirthdays[] = $man;
    }

    return "Сегодня день рождения у " . implode(PHP_EOL, $findBirthdays);
}

function helpFunction() {
    return handleHelp();
}

function readConfig(string $configAddress): array|false{
    return parse_ini_file($configAddress, true);
}

function readProfilesDirectory(array $config): string {
    $profilesDirectoryAddress = $config['profiles']['address'];

    if(!is_dir($profilesDirectoryAddress)){
        mkdir($profilesDirectoryAddress);
    }

    $files = scandir($profilesDirectoryAddress);

    $result = "";

    if(count($files) > 2){
        foreach($files as $file){
            if(in_array($file, ['.', '..']))
                continue;
            
            $result .= $file . "\r\n";
        }
    }
    else {
        $result .= "Директория пуста \r\n";
    }

    return $result;
}

function readProfile(array $config): string {
    $profilesDirectoryAddress = $config['profiles']['address'];

    if(!isset($_SERVER['argv'][2])){
        return handleError("Не указан файл профиля");
    }

    $profileFileName = $profilesDirectoryAddress . $_SERVER['argv'][2] . ".json";

    if(!file_exists($profileFileName)){
        return handleError("Файл $profileFileName не существует");
    }

    $contentJson = file_get_contents($profileFileName);
    $contentArray = json_decode($contentJson, true);

    $info = "Имя: " . $contentArray['name'] . "\r\n";
    $info .= "Фамилия: " . $contentArray['lastname'] . "\r\n";

    return $info;
}