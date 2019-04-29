<?php

// debugging tool
function writep($var)
{
    if (is_array($var)) {
        write_arr($var);
    } else if ($var) {
        echo "<div class='card card-body text-white bg-warning'>";
        echo "<p class='card-text'> $var </p>";
        echo "</div>";
    } else {
        echo "<div class='card card-body text-white bg-danger'>";
        echo "<p class='card-text'> Variable is Empty </p>";
        echo "</div>";
    }
};

function write_arr($var)
{
    echo "<pre class='card card-body text-white bg-warning'>";
    print_r($var);
    echo "</pre>";
};

function dump($var)
{
    echo "
        <pre class='card card-body text-white bg-warning'>";
    var_dump($var);
    echo "</pre>";
};
