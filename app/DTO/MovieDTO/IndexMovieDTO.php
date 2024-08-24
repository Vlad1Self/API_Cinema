<?php

namespace App\DTO\MovieDTO;

use Spatie\DataTransferObject\DataTransferObject;

class IndexMovieDTO extends DataTransferObject
{
    public  int $page;
    public  int $per_page;
}
