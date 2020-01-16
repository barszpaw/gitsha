<?php


namespace App\BranchChecksum;


interface ServiceInterface
{
    function getSha(): string;
}
