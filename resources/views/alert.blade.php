@if(session('success'))
            <div class="alert alert-success d-flex justify-content-between position-relative w-100 bottom-100 left-50 right-50" id="success-alert" role="alert" style="right: 0% !important; bottom: 100%;">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if(session('error'))
            <div class="alert alert-danger d-flex justify-content-between position-relative w-100 bottom-100 left-50 right-50" role="alert" id="error-alert" style="right: 0% !important; bottom: 100%;">
                    {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            
            @endif

            