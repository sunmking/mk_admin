<?php

namespace app\api\controller;

use app\BaseController;
use Intervention\Image\ImageManagerStatic as ImageMs;
use think\App;
use think\exception\ValidateException;
use think\facade\Filesystem;
use think\response\Json;

class Upload extends BaseController
{
    public function __construct(App $app)
    {
        ImageMs::configure(['driver' => 'imagick']);
        parent::__construct($app);
    }

    //单文件上传
    public function uploadSingle(): Json
    {
        $platform = $this->request->param('platform', '', 'trim');
        $crop = $this->request->param('crop', 1, 'int');
        $real_path = 'uploads';
        $platform && $real_path = $real_path.'/'.$platform;
        // 获取表单上传文件 例如上传了001.jpg
        $file = $this->request->file('file');

        if ($platform == 'banner') {
            $width = 1920;
            $height = 549;
        } elseif ($platform == 'post') {
            $width = 350;
            $height = 230;
        } elseif ($platform == 'page') {
            $width = 350;
            $height = 230;
        } else {
            $width = 0;
            $height = 0;
        }
        // 移动到框架应用根目录/uploads/ 目录下
        try {
            validate(['file' => ['fileSize:102400000,fileExt:jpg,JPG,png,jpeg,webp']])->check(['file' => $file]);
            //上传到服务器,
            $path = Filesystem::disk('public')->putFile($real_path, $file);
            // 获取public目录下的 storage，
            $picCover = Filesystem::getDiskConfig('public', 'url').'/'.str_replace('\\', '/', $path);
            // 等比裁剪
            if ($crop === 2 && ($width > 0 && $height > 0)) {
                $img = ImageMs::make(root_path().'/public'.$picCover);
                // resize image instance
                $img->fit($width, $height);
                // save image in desired format
                $img->save(root_path().'/public'.$picCover);
            }
            //结果是 $picCover = /storage/import/offline/20201214\c2dae**.jpg
            return json_ok(200, '上传成功', [
                'name' => $file->getOriginalName(),
                'path' => $picCover,
            ]);
        } catch (ValidateException $e) {
            // 上传失败获取错误信息
            return json_ok('1000', $e->getMessage(), []);
        }
    }

    /**
     * 多文件上传
     */
    public function uploadMultiple(): Json
    {
        $platform = $this->request->param('platform', '', 'trim');
        $crop = $this->request->param('crop', 1, 'int');
        $real_path = 'uploads';
        $platform && $real_path = $real_path.'/'.$platform;
        // 获取表单上传文件 例如上传了001.jpg
        $files = $this->request->file('file');
        // 移动到框架应用根目录/uploads/ 目录下
        try {
            validate(['file' => ['fileSize:102400000,fileExt:jpg,JPG,png,jpeg,webp']])->check($files);
            $upload_data = [];
            foreach ($files as $file) {
                //上传到服务器,
                $path = Filesystem::disk('public')->putFile($real_path, $file);
                // 获取public目录下的 storage，
                $picCover = Filesystem::getDiskConfig('public', 'url').'/'.str_replace('\\', '/', $path);
                // 等比裁剪
                if ($crop == 2) {
                    $img = ImageMs::make(root_path().'/public'.$picCover);
                    // resize image instance
                    $img->fit(480, 300);
                    // save image in desired format
                    $img->save(root_path().'/public'.$picCover);
                }
                $upload_data[] = [
                    'name' => $file->getOriginalName(),
                    'path' => $picCover,

                ];
            }

            return json_ok(200, '上传成功', $upload_data);
        } catch (\think\exception\ValidateException $e) {
            // 上传失败获取错误信息
            return json_ok(1000, $e->getMessage(), []);
        }
    }

    /**
     * 富文本 图片上传
     */
    public function uploadEdit(): Json
    {
        $platform = $this->request->param('platform', 1, 'trim');
        $crop = $this->request->param('crop', 1, 'int');
        $real_path = 'uploads';
        $platform && $real_path = $real_path.'/'.$platform;
        // 获取表单上传文件 例如上传了001.jpg
        $file = $this->request->file('file');

        if ($platform == 'goods') {
            $width = 720;
            $height = 480;
        } elseif ($platform == 'shop') {
            $width = 720;
            $height = 720;
        } else {
            $width = 0;
            $height = 0;
        }
        // 移动到框架应用根目录/uploads/ 目录下
        try {
            validate(['file' => ['fileSize:102400000,fileExt:image/png,jpg,JPG,png,PNG,JPEG,jpeg,webp']])->check(['file' => $file]);
            //上传到服务器,
            $path = Filesystem::disk('public')->putFile($real_path, $file);
            // 获取public目录下的 storage，
            $picCover = Filesystem::getDiskConfig('public', 'url').'/'.str_replace('\\', '/', $path);
            // 裁剪&质量压缩
            if ($crop == 2 && ($width > 0 && $height > 0)) {
                $img = ImageMs::make(root_path().'/public'.$picCover);
                // resize image instance
                $img->fit($width, $height);
                // save image in desired format
                $img->save(root_path().'/public'.$picCover);
            }

            return json_ok(200, '上传成功', [
                'name' => $file->getOriginalName(),
                'path' => $picCover,

            ]);
        } catch (ValidateException $e) {
            // 上传失败获取错误信息
            return json_ok(1000, $e->getMessage(), []);
        }
    }
}
