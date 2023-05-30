<?php
use \Psr\Container\ContainerInterface;
use Slim\Http\UploadedFile;

class admincontroller extends Controller
{   
    public function login($request, $response, $args) {

        $data = $request->getParsedBody();

        $admin = new Admin($this->container);
        $user = $admin->retrieve_account_password($data);

        if ($user) {
            Session::set('user_id', $user['user_id']);
            $result = [
                "status" => "success",
                "message" => "登入成功"
            ];
        } else {
            $result = [
                "status" => "failed",
                "message" => "登入失敗"
            ];
        }

        return $this->responseJson($response, $result);

    }

    function compressImage($source = false, $destination = false, $quality = 80, $filters = false) {
        $info = getimagesize($source);
        switch ($info['mime']) {
            case 'image/jpeg':
                /* Quality: integer 0 - 100 */
                if (!is_int($quality) or $quality < 0 or $quality > 100) $quality = 80;
                return imagecreatefromjpeg($source);

            case 'image/gif':
                return imagecreatefromgif($source);

            case 'image/png':
                /* Quality: Compression integer 0(none) - 9(max) */
                if (!is_int($quality) or $quality < 0 or $quality > 9) $quality = 6;
                return imagecreatefrompng($source);

            case 'image/webp':
                /* Quality: Compression 0(lowest) - 100(highest) */
                if (!is_int($quality) or $quality < 0 or $quality > 100) $quality = 80;
                return imagecreatefromwebp($source);

            case 'image/bmp':
                /* Quality: Boolean for compression */
                if (!is_bool($quality)) $quality = true;
                return imagecreatefrombmp($source);

            default:
                return;
        }
    }

    function get_picture($request, $response, $args) {
        $data = $request->getQueryParams();
        $Admin = new Admin($this->container);
        $file_name = $Admin->get_picture($data);
        $file = $this->container->upload_directory . DIRECTORY_SEPARATOR . $file_name;
        if (!file_exists($file)) {
            $file = $this->container->upload_directory . DIRECTORY_SEPARATOR . "quotation.png";
            $source = $this->compressImage($file, $file, 100);
            // return $this->response_return($response, $file);
            // $response = $response->withStatus(500);
            // return $response;
        }
        else $source = $this->compressImage($file, $file, 100);
        // imagejpeg($source);

        $response = $response->withHeader('Content-Description', 'File Transfer')
            ->withHeader('Content-Type', 'application/octet-stream')
            ->withHeader('Content-Disposition', 'attachment;filename="' . $file_name . '"')
            ->withHeader('Expires', '0')
            ->withHeader('Cache-Control', 'must-revalidate')
            ->withHeader('Pragma', 'public')
            ->withHeader('Content-Length', filesize($file));
        ob_clean();
        ob_end_flush();
        // $source = imagecreatefromjpeg($file);
        // Load

        // Output
        imagejpeg($source);
        imagealphablending($source, false);
        imagesavealpha($source, true);
        imagepng($source);
        imagedestroy($source);
        return $response;
    }


    function moveUploadedFile($directory, UploadedFile $uploadedFile) {
        $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
        $basename = bin2hex(random_bytes(8)); // see http://php.net/manual/en/function.random-bytes.php
        $filename = sprintf('%s.%0.8s', $basename, $extension);
        $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);
        return $filename;
    }


    public function upload_picture($request, $response, $args) {
        $Admin = new Admin($this->container);
        $data = $request->getParsedBody();
        $directory = $this->container->upload_directory;  //Get the directory of the space which stores pictures, video, etc.
        $uploadedFiles = $request->getUploadedFiles();    //Get the temporary file that stores in php's register.
        $uploadedFile = $uploadedFiles['inputFile'];
         
        //Check the file is no error.
        if ($uploadedFile->getError() === UPLOAD_ERR_OK) 
        {                
            $filename = $this->moveUploadedFile($directory, $uploadedFile);
            //Move the uploaded file from register to the correct directory.
            $data['file_client_name'] = $uploadedFile->getClientFilename();
            $data['file_name'] = $filename;
            $result = $Admin->post_photo($data);
            return $this->responseJson($response, $result);
        }
    
        return $this->responseJson($response, ["status" => "faile"]);
        
    }

    public function remove_picture($request, $response, $args) {
        $data = $request->getParsedBody();
        $Admin = new Admin($this->container);
        $directory = $this->container->upload_directory;
        $file_name = $Admin->get_picture($data);
        unlink($directory . DIRECTORY_SEPARATOR . $file_name);
        $result = $Admin->delete_photo($data);
        return $this->responseJson($response, $result);
    }

}