<?php

/*
 * 328/dating/model/dataLayer.php
 * Phillip Ball
 * 05/15/2021
 * I'm treating this file to basically be a database
 * and will use it to reduce redundancy with templating
*/

function getUserQuotes(){
    return array("Sprinkles" => "I've finally found my cupcake!",
        "Chubbs" => "Food was the only thing that made me happy before, now I have someone to enjoy food with and it couldn't be better.",
        "Princess Stinky Pants the 3rd" => "Meow!");
}

function getIndoorBoxes(){
    return array("sleeping", "eating", "interrupting humans", "playing",
        "zooming", "kneading", "sitting", "breaking things");
}

function getOutdoorBoxes(){
    return array("sunbathing", "playing", "sleeping", "hunting leaves",
        "stalking", "getting stuck");
}