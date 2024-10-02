<?php

namespace App\Enum;

enum MediaTypeEnum: string
{
    case VIDEO = 'video';
    case AUDIO = 'audio';
    case IMAGE = 'image';
    case TEXT = 'text';
    case PDF = 'pdf';
    case DOC = 'doc';
    case DOCX = 'docx';
    case PPT = 'ppt';
    case PPTX = 'pptx';
    case XLS = 'xls';
    case XLSX = 'xlsx';
    case CSV = 'csv';
    case ZIP = 'zip';
    case RAR = 'rar';
}