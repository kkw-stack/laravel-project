@isset($files)
    @if($files->count() > 0)
        <div class="jt-single__attachments">
            <span class="sr-only">{!! __('front.ui.attachments') !!}</span>
            <div class="jt-download-files">
                @foreach($files as $file)
                    <a href="{{ Storage::url($file->file_path) }}" download="{{ $file->file_name }}">
                        <i class="jt-icon">
                            <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M13.4,5.2V13a3.47,3.47,0,0,1-1,2.41,3.22,3.22,0,0,1-2.38,1,3.31,3.31,0,0,1-2.42-1A3.19,3.19,0,0,1,6.6,13V5.6a2,2,0,0,1,2-2A1.89,1.89,0,0,1,10,4.18,2,2,0,0,1,10.6,5.6v7a.6.6,0,1,1-1.2,0V5.2H7.8v7.4A2.19,2.19,0,0,0,10,14.8a2.19,2.19,0,0,0,2.2-2.2v-7a3.47,3.47,0,0,0-1-2.55A3.47,3.47,0,0,0,8.6,2a3.47,3.47,0,0,0-2.55,1A3.47,3.47,0,0,0,5,5.6V13a5,5,0,0,0,5,5,5,5,0,0,0,5-5V5.2Z"/>
                            </svg>
                        </i><!-- .jt-icon -->
                        <span class="jt-typo--16">{{ $file->file_name }}</span>
                    </a>
                @endforeach
            </div><!-- .jt-download-files -->
        </div><!-- .jt-single__attachments -->
    @endif
@endisset
