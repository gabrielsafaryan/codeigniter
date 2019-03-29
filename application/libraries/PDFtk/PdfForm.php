<?php defined('BASEPATH') OR exit('No direct script access allowed');

class PdfForm
{
    /*
  * Path to raw PDF form
  * @var string
  */
    private $pdfUrl;

    /*
    * Form data
    * @var array
    */
    private $data;

    /*
    * Path to filled PDF form
    * @var string
    */
    private $output;

    /*
    * Flag for flattening the file
    * @var string
    */
    private $flatten;

    /**
     * PdfForm constructor.
     * @param array $params
     */
    public function __construct($params)
    {
        $this->pdfUrl = $params['pdfUrl'];
        $this->data = $params['data'];
    }

    /**
     * @return bool|string
     */
    public function tmpfile()
    {
        return tempnam(sys_get_temp_dir(), gethostname());
    }

    /**
     * @param bool $pretty
     * @return false|string
     */
    public function fields($pretty = false)
    {
        $tmp = $this->tmpfile();

        exec("pdftk {$this->pdfUrl} dump_data_fields > {$tmp}");
        $con = file_get_contents($tmp);

        unlink($tmp);
        return $pretty == true ? nl2br($con) : $con;
    }

    /**
     * @param $data
     * @return bool|string
     */
    public function makeFdf($data)
    {
        $fdf = '%FDF-1.2
    1 0 obj<</FDF<< /Fields[';

        foreach ($data as $key => $value) {
            $fdf .= '<</T(' . $key . ')/V(' . $value . ')>>';
        }

        $fdf .= "] >> >>
                endobj
                trailer
                <</Root 1 0 R>>
                %%EOF";

        $fdf_file = $this->tmpfile();
        file_put_contents($fdf_file, $fdf);

        return $fdf_file;
    }

    /**
     * @return $this
     */
    public function flatten()
    {
        $this->flatten = 'flatten';
        return $this;
    }

    /**
     * Fill pdf form
     */
    private function generate()
    {
        $fdf = $this->makeFdf($this->data);
        $this->output = $this->tmpfile();
        exec("pdftk {$this->pdfUrl} fill_form {$fdf} output {$this->output} {$this->flatten}");

        unlink($fdf);
    }

    /**
     * @param $path
     * @return $this
     */
    public function save($path = null)
    {
        if (is_null($path)) {
            return $this;
        }

        if (!$this->output) {
            $this->generate();
        }

        $dest = pathinfo($path, PATHINFO_DIRNAME);
        if (!file_exists($dest)) {
            mkdir($dest, 0775, true);
        }

        copy($this->output, $path);
        unlink($this->output);

        $this->output = $path;

        return $this;
    }

    /**
     * Get created pdf and return download headers
     */
    public function download()
    {
        if (!$this->output) {
            $this->generate();
        }

        $filepath = $this->output;


        if (file_exists($filepath)) {

            header('Content-Description: File Transfer');
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename=' . uniqid(gethostname()) . '.pdf');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filepath));

            readfile($filepath);
            exit;
        }
    }
}