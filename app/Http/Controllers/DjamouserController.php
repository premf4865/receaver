<?php

namespace App\Http\Controllers;

use App\Models\Djamouser;
use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DjamouserController extends Controller
{
    public function store(Request $request)
       {
           // Valider les données entrantes
           $request->validate([
               'imageUrl' => 'required',
               'user_id' => 'required',
               'password' => 'required',
           ]);

           // Récupérer l'URL de l'image
            $base64Image = request()->input('imageUrl');

            if (!$tmpFileObject = $this->validateBase64($base64Image, ['png', 'jpg', 'jpeg', 'gif'])) {
                return response()->json([
                    'error' => 'Invalid image format.'
                ], 415);
            }

            $storedFilePath = $this->storeFile($tmpFileObject);

            if(!$storedFilePath) {
                return response()->json([
                    'error' => 'Something went wrong, the file was not stored.'
                ], 500);
            }

            $imageUrl = $storedFilePath;


           $user_id = $request->input('user_id');
           $password = $request->input('password');

           Djamouser::create([
              'image64' =>  $imageUrl,
               'user_id' => $user_id,
               'password' => $password,
           ]);

                       return response()->json([
                'image_url' => $imageUrl,
            ]);

           // Faire quelque chose avec l'URL de l'image, comme la stocker en base de données

           // Répondre à la requête
           return response()->json(['message' => 'Données reçues avec succès']);
       }

       private function storeFile(File $tmpFileObject)
{
    $tmpFileObjectPathName = $tmpFileObject->getPathname();

    $file = new UploadedFile(
        $tmpFileObjectPathName,
        $tmpFileObject->getFilename(),
        $tmpFileObject->getMimeType(),
        0,
        true
    );

    $storedFile = $file->store('', ['disk' => 'public']);

    unlink($tmpFileObjectPathName); // delete temp file

    return $storedFile;
}



private function validateBase64(string $base64data, array $allowedMimeTypes)
{
    // strip out data URI scheme information (see RFC 2397)
    if (str_contains($base64data, ';base64')) {
        list(, $base64data) = explode(';', $base64data);
        list(, $base64data) = explode(',', $base64data);
    }

    // strict mode filters for non-base64 alphabet characters
    if (base64_decode($base64data, true) === false) {
        return false;
    }

    // decoding and then re-encoding should not change the data
    if (base64_encode(base64_decode($base64data)) !== $base64data) {
        return false;
    }

    $fileBinaryData = base64_decode($base64data);

    // temporarily store the decoded data on the filesystem to be able to use it later on
    $tmpFileName = tempnam(sys_get_temp_dir(), 'medialibrary');
    file_put_contents($tmpFileName, $fileBinaryData);

    $tmpFileObject = new File($tmpFileName);

    // guard against invalid mime types
    $allowedMimeTypes = Arr::flatten($allowedMimeTypes);

    // if there are no allowed mime types, then any type should be ok
    if (empty($allowedMimeTypes)) {
        return $tmpFileObject;
    }

    // Check the mime types
    $validation = Validator::make(
        ['file' => $tmpFileObject],
        ['file' => 'mimes:' . implode(',', $allowedMimeTypes)]
    );

    if($validation->fails()) {
        return false;
    }

    return $tmpFileObject;
}
}
