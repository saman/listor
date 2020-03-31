<?php

/**
 * Listor
 * A simple directory lister script
 * @author Saman Soltani <me@samansoltani.com>
 */


$block_list = ['.', '..', '.DS_Store'];

$cur_dir = $_GET['dir'] ?: '';
$dir = __DIR__ . '/' . $cur_dir;
$list = scandir($dir);
$dirs = [];
$files = [];

foreach ($list as $value) {
    if ($dir . $value !== __FILE__ && !in_array($value, $block_list)) {
        if (is_dir($dir . $value)) {
            $dirs[] = $value;
        } else {
            $files[] = $value;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listor - <?= $cur_dir ?></title>
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
            width: 50%;
            margin: 50px auto 0 auto;
            padding: 10px;
            border: 1px solid #eee;
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

        .folder {
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
        }
    </style>
</head>

<body>
    <div class="main">
        <ul>
            <?php foreach ($dirs as $dir) { ?>
                <li>
                    <a href="./?dir=<?= rawurlencode($dir) ?>">
                        <div class="folder"></div>
                        <?= $dir ?>
                    </a>
                </li>
            <?php } ?>

            <?php foreach ($files as $file) { ?>
                <li>
                    <a href="./<?= rawurlencode($cur_dir) . '/' . rawurlencode($file) ?>">
                        <div class="file"></div>
                        <?= $file ?>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </div>
</body>

</html>
