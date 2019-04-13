<?php
namespace Support;

abstract class XlsxReader
{
    protected $fileMimes = [
        'text/x-comma-separated-values',
        'text/comma-separated-values',
        'application/octet-stream',
        'application/vnd.ms-excel',
        'application/x-csv',
        'text/x-csv',
        'text/csv',
        'application/csv',
        'application/excel',
        'application/vnd.msexcel',
        'text/plain',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
    ];

    protected $fileName;

    protected $fileType;

    protected $fileTmpName;

    protected $rows;

    /**
     * @return null
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    public function importFromUploadedFile()
    {
        if (!$this->getFile()) {
            return null;
        }

        $extension  = $this->getExtension();

        $reader = $this->getReader($extension);

        $spreadsheet = $reader->load($this->fileTmpName);

        $this->rows = $spreadsheet->getActiveSheet()->toArray();
    }

    private function getFile() {

        $this->fileName = isset($_FILES['file']['name']) ? $_FILES['file']['name'] : null;

        if(!$this->fileName){
            return false;
        }

        $this->fileType = isset($_FILES['file']['type']) ? $_FILES['file']['type'] : null;

        if(!$this->fileType || !in_array($this->fileType, $this->fileMimes)){
            return false;
        }

        $this->fileTmpName = isset($_FILES['file']['tmp_name']) ? $_FILES['file']['tmp_name'] : null;

        if(!$this->fileTmpName){
            return false;
        }

        return true;
    }

    private function getExtension()
    {
        $arrFile = explode('.', $this->fileName);

        $extension = end($arrFile);

        return $extension;
    }

    private function getReader($extension)
    {
        if ($extension == 'csv') {
            return new \PhpOffice\PhpSpreadsheet\Reader\Csv();
        }

        return new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
    }
}
