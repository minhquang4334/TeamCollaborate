<?php

namespace App\Http\Controllers\Api;

use App\Events\FileUploaded;
use App\Http\Requests\User\FileRequest;
use App\Repositories\ChannelRepository;
use App\Repositories\FileRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\EventDispatcher\Tests\GenericEventTest;

class FileApiController extends ApiController
{
    protected $file;
    protected $channel;
    /**
     * FileApiController constructor.
     * @param FileRepository $file
     */
    public function __construct(FileRepository $file, ChannelRepository $channel)
    {
        parent::__construct();
        $this->file = $file;
        $this->channel = $channel;
    }

    /**
     * @method POST
     * @usage http://localhost:8000/api/file/upload?channel_id=2&post_id=2&creator=1&file={{form-data}}
     * store file
     * FileRequest check file type, file size ( < 2mb )
     * request has channel_id, post_id, creator
     * return file_path and file information if store success, if not return error code
     * @param FileRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(FileRequest $request) {
        try{

            $channelID = $request->get('channel_id');
            $channel = $this->channel->getChannelById($channelID);

            // Check user is in channel
            if($this->currentUser()->channels->contains($channel)) {
                $imageTypes = ['image/jpeg', 'image/gif', 'image/png', 'image/bmp', 'image/svg+xml'];
                $file = $request->file('file');
                $contentType = mime_content_type($file->getRealPath());

                $isImage = in_array($contentType, $imageTypes) ? 1 : 0;

                // fill variables
                $filename = time() . str_random(16) . '.' . $file->clientExtension();

                // upload it
                Storage::putFileAs('public/' . $channelID, $file, $filename);
                $fileAddress = 'storage/' . $channelID . '/' . $filename;

                $stored = $this->file->store(array_merge($request->all(), ['is_image' => $isImage,
                    'file_path' => $fileAddress,
                    'file_name' => $file->getClientOriginalName(),
                    'creator'   => $this->currentUser()->id,
                    'channel_id'   => $channel->id
                ]));
                event(new FileUploaded($stored, $channelID));
                return $this->response->withCreated($stored);
            }else{
                return $this->response->withForbidden(trans('messages.user.permission_deny'));
            }

        } catch (\Exception $e) {
            return $this->response->withInternalServer($e->getMessage());
        }
    }

    /**
     * @method GET
     * @usage http://localhost:8000/api/file/list?channel_id=2
     * get list file in channel
     * $request has channel_id
     * return list file in channel
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getListFile(Request $request) {
        try{
            $channelID = $request->get('channel_id');
            $channel = $this->channel->getById($channelID);

            // Check user is in channel
            if($this->currentUser()->channels->contains($channel)) {
                $files = $channel->files;
                return $this->response->withArray($files);
            }else{
                return $this->response->withForbidden(trans('messages.user.permission_deny'));
            }
        } catch (\Exception $e) {
            return $this->response->withInternalServer($e->getMessage());
        }
    }

    /**
     * @method delete
     * @usage http://localhost:8000/api/file/delete?file_id=11
     * remove file in channel
     * $request has file_id
     * return true if remove success, if not return error code
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeFile(Request $request) {
        try{
            $fileId = $request->get('file_id');
            $file = $this->file->getById($fileId);

            // Check user is in channel
            if($file->creator == $this->currentUser()->id) {
                $file->delete();
                Storage::delete('public' . $file->file_path);
                return $this->response->withUpdated($file);
            }else{
                return $this->response->withForbidden(trans('messages.user.permission_deny'));
            }
        } catch (\Exception $e) {
            return $this->response->withInternalServer($e->getMessage());
        }
    }

    /**
     * @method Get
     * @usage
     * get file path
     * $request has file_id
     * return file path
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFilePath(Request $request) {
        try{
            $fileID = $request->get('file_id');
            $file = $this->file->getById($fileID);
            $channel = $file->channel;

            // Check user is in channel
            if($this->currentUser()->channels->contains($channel)) {
                return $this->response->withMessage($file->file_path);
            }else{
                return $this->response->withForbidden(trans('messages.user.permission_deny'));
            }
        } catch (\Exception $e) {
            return $this->response->withInternalServer($e->getMessage());
        }
    }




}
