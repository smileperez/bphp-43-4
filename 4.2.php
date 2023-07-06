<?php
declare(strict_types=1);

$items = [];

const OPERATION_EXIT = 0;
const OPERATION_ADD = 1;
const OPERATION_DELETE = 2;
const OPERATION_PRINT = 3;

$operations = [
    OPERATION_EXIT => OPERATION_EXIT . '. Завершить программу.',
    OPERATION_ADD => OPERATION_ADD . '. Добавить товар в список покупок.',
    OPERATION_DELETE => OPERATION_DELETE . '. Удалить товар из списка покупок.',
    OPERATION_PRINT => OPERATION_PRINT . '. Отобразить список покупок.',
];

do {
    system('cls');

    $operationNumber = playMenu($items, $operations);

    echo 'Выбрана операция: '  . $operations[$operationNumber] . PHP_EOL;

    switch ($operationNumber) {
        case OPERATION_ADD:
            $items = addItems($items);
            break;

        case OPERATION_DELETE:
            $items = deleteItems($items);
            echo 'Нажмите enter для продолжения';
            fgets(STDIN);
            break;

        case OPERATION_PRINT:
            printItems($items);
            echo 'Нажмите enter для продолжения';
            fgets(STDIN);
            break;
    }

    echo "\n ----- \n";
} while ($operationNumber > 0);

echo 'Программа завершена' . PHP_EOL;


// Функции

function addItems(array $arr): array {
    echo "Введение название товара для добавления в список: \n> ";
    $itemName = trim(fgets(STDIN));
    array_push($arr, $itemName);
    return $arr;
}

function deleteItems(array $arr): array {
    if (empty($arr)) {
        printEmpty();
        return $arr;

    } else {
        printItems($arr);
        echo 'Введите название товара для удаления из списка:' . PHP_EOL . '> ';
        $itemName = trim(fgets(STDIN));

        if (in_array($itemName, $arr, true) !== false) {
            while (($key = array_search($itemName, $arr, true)) !== false) {
                unset($arr[$key]);
            }
        }
        return $arr;
    } 
}

function printItems(array $arr): array {
    echo 'Ваш список покупок: ' . PHP_EOL;
    echo implode(PHP_EOL, $arr) . PHP_EOL;
    echo 'Всего ' . count($arr) . ' позиций. '. PHP_EOL;
    return $arr;
}

function printEmpty() {
    echo 'Список покупок пуст.' . PHP_EOL . '> ';
    echo 'Введите другую команду.' . PHP_EOL . '> ';
}

function playMenu(array $arr, array $operations) {
    do {
        if (count($arr)) {
            echo 'Ваш список покупок: ' . PHP_EOL;
            echo implode("\n", $arr) . "\n";
        } else {
            echo 'Ваш список покупок пуст.' . PHP_EOL;
        }

        echo 'Выберите операцию для выполнения: ' . PHP_EOL;
        
        if (empty($arr)) {
            echo implode(PHP_EOL, array_slice($operations, 0, count($operations)-1)) . PHP_EOL . '> ';
        } else {
            echo implode(PHP_EOL, $operations) . PHP_EOL . '> ';
        }

        $operationNumber = trim(fgets(STDIN));
    
        if (!array_key_exists($operationNumber, $operations)) {
            system('clear');
    
            echo '!!! Неизвестный номер операции, повторите попытку.' . PHP_EOL;
        }

    } while (!array_key_exists($operationNumber, $operations));
    return $operationNumber;
}
