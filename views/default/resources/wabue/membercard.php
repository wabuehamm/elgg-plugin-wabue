<?php

$member = elgg_get_logged_in_user_entity();
$year = "2020";

?>
<div id="membercard">
    <div id="icon"><img src="<?php echo $member->getIconURL("large"); ?>" alt="<?php echo $member->getDisplayName(); ?>"></img></div>
    <div id="right">
        <div id="title">Mitgliedsausweis</div>
        <div id="company">
            Westfälische Freilichtspiele e.V.<br />
            Waldbühne Heessen
        </div>
        <div id="name"><?php echo $member->getDisplayName(); ?></div>
        <div id="year">Spielzeit <?php echo $year; ?></div>
    </div>
</div>
<style>
    @import url('https://fonts.googleapis.com/css?family=Open+Sans:300,400,700&display=swap');

    @media print {
        div#membercard {
            width: 8cm;
            height: 5cm;
            grid-template-rows: 5cm;
        }

        div#icon img {
            width: 3.4cm;
            height: 4.5cm;
        }

        body {
            font-size: 5px;
        }
    }

    @media screen {
        div#membercard {
            width: 63em;
            height: 37em;
            grid-template-rows: 37em;
        }

        div#icon img {
            width: 26em;
            height: 35em;
        }

        body {
            font-size: 1em;
        }
    }

    div#membercard {
        display: grid;
        grid-template-columns: 50% auto;
        grid-gap: 1px;
        border: 1px solid black;
        margin: auto;
        margin-top: 1em;
    }

    div#icon {
        grid-column: 1;
        grid-row: 1;
        background-color: white;
        align-self: center;
        justify-self: center;
    }

    div#right {
        grid-column: 2;
        grid-row: 1;
        background-color: white;
        background-image: url(<?php echo elgg_get_simplecache_url('graphics/membershipcard_logo.png'); ?>);
        background-repeat: no-repeat;
        background-position: bottom right;
        background-size: 17em;
        display: grid;
        grid-template-columns: auto;
        grid-template-rows: 4.5em 3em auto 3em;
        text-align: center;
        padding: 1em;
    }

    div#title {
        grid-column: 1;
        grid-row: 1;
        font-size: 3em;
        font-weight: bold;
    }

    div#company {
        grid-column: 1;
        grid-row: 2;
        font-size: 1em;
        font-weight: lighter;
    }

    div#name {
        grid-column: 1;
        grid-row: 3;
        font-size: 2em;
        font-weight: bold;
        align-self: center;
    }

    div#year {
        grid-column: 1;
        grid-row: 4;
        font-size: 2em;
        font-weight: bold;
        text-align: right;
    }

    body {
        margin: 0;
        padding: 0;
        font-family: 'Open Sans', sans-serif;
        line-height: 1.5;
    }
</style>