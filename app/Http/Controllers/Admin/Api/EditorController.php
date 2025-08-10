<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('editor')]
class EditorController extends Controller
{
    #[Post('upload', 'admin.api.editor.upload')]
    public function upload(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimetypes:image/*']
        ]);

        $path = $request->file('file')->store('editor', 'public');

        return array(
            'location' => Storage::url($path),
        );
    }
}
