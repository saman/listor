<?php

/**
 * Listor
 * A simple directory lister script
 * @author Saman Soltani <me@samansoltani.com>
 */


$block_list = ['.', '..', '.DS_Store'];

$current_path = $_GET['p'] ?: '';
$current_path_arr = explode('/', $current_path);
$path = __DIR__ . '/' . $current_path;
$list = scandir($path);
$dirs = [];
$files = [];

foreach ($list as $value) {
    if ($path . $value !== __FILE__ && !in_array($value, $block_list)) {
        if (is_dir($path . '/' . $value)) {
            $dirs[] = [
                'name' => $value,
                'type' => 'dir',
                'link' => '?p=' . rawurlencode(strlen($current_path) ? $current_path . '/' . $value : $value)
            ];
        } else {
            $files[] = [
                'name' => $value,
                'size' => filesize($path . '/' . $value),
                'type' => 'file',
                'link' => rawurlencode($current_path) . '/' . rawurlencode($value)
            ];
        }
    }
}

$list = array_merge($dirs, $files);

function human_filesize($bytes, $decimals = 2)
{
    $sz = 'BKMGTP';
    $factor = floor((strlen($bytes) - 1) / 3);
    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . ' ' . @$sz[$factor];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listor<?= strlen($current_path) ? ' - ' . $current_path : '' ?></title>
    <style>
        html,
        body {
            margin: 0;
            padding: 0;
            font-family: sans-serif;
            font-size: 12px;
            color: #333;
        }

        .main {
            width: 960px;
            margin: 50px auto 0 auto;
        }

        .row {
            margin: 2px 0;
            padding: 5px;
        }

        .row:hover {
            background: #f9f9f9;
        }

        .row::after {
            content: "";
            clear: both;
            display: table;
        }

        .col1 {
            width: 8.33%;
            float: left;
        }

        .col11 {
            width: 91.66%;
            float: left;
        }

        .col10 {
            width: 83.33%;
            float: left;
        }

        .list {
            border: 1px solid #eee;
            padding: 10px;
        }

        .list> :first-child {
            margin-top: 0 !important;
        }

        .list> :last-child {
            margin-bottom: 0 !important;
        }

        .breadcrumb {
            margin-bottom: 10px
        }

        .breadcrumb span {
            margin: 0 2px;
        }

        .breadcrumb span,
        .breadcrumb a {
            float: left;
        }

        .breadcrumb .clear {
            clear: both;
        }

        a,
        a:visited {
            text-decoration: none;
            color: #333;
        }

        a:hover {
            color: #888
        }

        ul {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        li {
            margin: 10px 5px;
        }

        .dir {
            height: 15px;
            width: 15px;
            background: url('data:image/svg+xml;base64,PHN2ZyBhcmlhLWhpZGRlbj0idHJ1ZSIgZm9jdXNhYmxlPSJmYWxzZSIgZGF0YS1wcmVmaXg9ImZhcyIgZGF0YS1pY29uPSJmb2xkZXIiIGNsYXNzPSJzdmctaW5saW5lLS1mYSBmYS1mb2xkZXIgZmEtdy0xNiIgcm9sZT0iaW1nIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCA1MTIgNTEyIj48cGF0aCBmaWxsPSJjdXJyZW50Q29sb3IiIGQ9Ik00NjQgMTI4SDI3MmwtNjQtNjRINDhDMjEuNDkgNjQgMCA4NS40OSAwIDExMnYyODhjMCAyNi41MSAyMS40OSA0OCA0OCA0OGg0MTZjMjYuNTEgMCA0OC0yMS40OSA0OC00OFYxNzZjMC0yNi41MS0yMS40OS00OC00OC00OHoiPjwvcGF0aD48L3N2Zz4=');
            background-repeat: no-repeat;
            float: left;
            margin-right: 5px;
            margin-top: -1px;
        }

        .file {
            background: url('data:image/svg+xml;base64,PHN2ZyBhcmlhLWhpZGRlbj0idHJ1ZSIgZm9jdXNhYmxlPSJmYWxzZSIgZGF0YS1wcmVmaXg9ImZhbCIgZGF0YS1pY29uPSJmaWxlIiByb2xlPSJpbWciIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgdmlld0JveD0iMCAwIDM4NCA1MTIiIGNsYXNzPSJzdmctaW5saW5lLS1mYSBmYS1maWxlIGZhLXctMTIgZmEtM3giPjxwYXRoIGZpbGw9ImN1cnJlbnRDb2xvciIgZD0iTTM2OS45IDk3LjlMMjg2IDE0QzI3NyA1IDI2NC44LS4xIDI1Mi4xLS4xSDQ4QzIxLjUgMCAwIDIxLjUgMCA0OHY0MTZjMCAyNi41IDIxLjUgNDggNDggNDhoMjg4YzI2LjUgMCA0OC0yMS41IDQ4LTQ4VjEzMS45YzAtMTIuNy01LjEtMjUtMTQuMS0zNHptLTIyLjYgMjIuN2MyLjEgMi4xIDMuNSA0LjYgNC4yIDcuNEgyNTZWMzIuNWMyLjguNyA1LjMgMi4xIDcuNCA0LjJsODMuOSA4My45ek0zMzYgNDgwSDQ4Yy04LjggMC0xNi03LjItMTYtMTZWNDhjMC04LjggNy4yLTE2IDE2LTE2aDE3NnYxMDRjMCAxMy4zIDEwLjcgMjQgMjQgMjRoMTA0djMwNGMwIDguOC03LjIgMTYtMTYgMTZ6IiBjbGFzcz0iIj48L3BhdGg+PC9zdmc+');
            background-repeat: no-repeat;
            height: 15px;
            width: 15px;
            float: left;
            margin-right: 5px;
            margin-top: -1px;
        }
    </style>
</head>

<body>
    <div class="main">
        <div class="breadcrumb">
            <a href="./">Home</a>
            <?php
            $path_till_now = '';
            foreach ($current_path_arr as $value) {
                $path_till_now .=  $value . '/';
            ?>
                <span>/</span>
                <a href="./?p=<?= rawurlencode(rtrim($path_till_now, '/')) ?>"><?= $value ?></a>
            <?php } ?>
            <div class="clear"></div>
        </div>
        <div class="list">

            <?php foreach ($list as $item) { ?>
                <div class="row">
                    <div class="col11">
                        <a href="./<?= $item['link'] ?>">
                            <div class="<?= $item['type'] ?>"></div>
                            <?= $item['name'] ?>
                        </a>
                    </div>
                    <div class="col1">
                        <?= isset($item['size']) ? human_filesize($item['size']) : ''  ?>
                    </div>
                </div>
            <?php } ?>

        </div>
    </div>
</body>

</html>