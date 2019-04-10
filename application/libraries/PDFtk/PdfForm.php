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
        $this->CI = get_instance();
        $this->CI->load->library('fpdf');
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

        $path = FCPATH.'/public/created_ci.pdf';
        exec("pdftk {$this->pdfUrl} fill_form {$fdf} output {$path} {$this->flatten}");

        //unlink($fdf);
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

        $path = FCPATH.'/public/created_ci.pdf';
        $this->CI->fpdf->AddPage();
        $this->CI->fpdf->AddPage();
        $image_name = $this->data['signature'];

        $this->CI->fpdf->Image(FCPATH."public/images/{$image_name}",50,47,12,12,NULL,$path);
        $this->CI->fpdf->AddPage();
        $this->CI->fpdf->AddPage();
        $this->CI->fpdf->AddPage();
        $this->CI->fpdf->AddPage();
        $this->CI->fpdf->Output('F');
        $signature = FCPATH.'doc.pdf';
        $output = FCPATH.'/public/created_ci3.pdf';

        exec("pdftk  {$path} multistamp {$signature} output {$output}");
        $return_data = [];
        if (file_exists($output)) {

            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename='.basename($output));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($output));
            ob_clean();
            flush();
            readfile($output);

            $return_data = [
                'output'    => $output,
                'signature' => $signature,
                'path'      => $path,

            ];
        }

        return $return_data;
    }
}