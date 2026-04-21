<!DOCTYPE html>
<html lang="en">

<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>File Manager</title>
      <!-- Bootstrap 5 CSS -->
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
      <!-- Bootstrap Icons -->
      <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css" />

      <style>
            body {
                  background-color: #f8f9fa;
                  padding: 30px;
                  font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            }

            .upload-form {
                  padding-top: 15px;
                  /* background: #8d8c8c; */
                  border: 1px solid #efefef;
                  padding-left: 15px;
            }

            .file-manager-container {
                  background: white;
                  border-radius: 12px;
                  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
                  padding: 25px;
                  max-width: 1400px;
                  margin: 0 auto;
            }

            .header-section {
                  margin-bottom: 30px;
                  padding-bottom: 20px;
                  border-bottom: 1px solid #e9ecef;
            }

            .page-title {
                  color: #2c3e50;
                  font-weight: 600;
                  margin-bottom: 25px;
                  font-size: 1.8rem;
            }

            .search-container {
                  width: auto;
                  margin-bottom: 20px;
            }

            .search-bar {
                  border-radius: 8px;
                  overflow: hidden;
                  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.08);
            }

            .search-bar .form-control {
                  border: 1px solid #dee2e6;
                  border-right: none;
                  padding: 12px 16px;
                  font-size: 1rem;
            }

            .search-bar .btn {
                  background-color: #4361ee;
                  border: 1px solid #4361ee;
                  padding: 12px 24px;
                  font-weight: 500;
            }

            .search-bar .btn:hover {
                  background-color: #3a56d4;
                  border-color: #3a56d4;
            }

            .file-card {
                  border: 1px solid #e9ecef;
                  border-radius: 10px;
                  overflow: hidden;
                  transition: all 0.3s ease;
                  height: 100%;
                  background: white;
            }

            .file-card:hover {
                  transform: translateY(-5px);
                  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
                  border-color: #4361ee;
            }

            .card-img-container {
                  height: 160px;
                  overflow: hidden;
                  background-color: #f8f9fa;
                  display: flex;
                  align-items: center;
                  justify-content: center;
            }

            .card-img-top {
                  width: 100%;
                  height: 100%;
                  object-fit: cover;
            }

            .card-body {
                  padding: 15px;
                  text-align: center;
            }

            .card-title {
                  font-size: 0.95rem;
                  font-weight: 500;
                  color: #2c3e50;
                  margin-bottom: 10px;
                  white-space: nowrap;
                  overflow: hidden;
                  text-overflow: ellipsis;
            }

            .use-file-btn {
                  background-color: #4361ee;
                  border: none;
                  border-radius: 6px;
                  padding: 8px 16px;
                  font-size: 0.9rem;
                  font-weight: 500;
                  width: 100%;
                  transition: background-color 0.2s;
            }

            .use-file-btn:hover {
                  background-color: #3a56d4;
            }

            .pagination-container {
                  margin-top: 40px;
                  padding-top: 20px;
                  border-top: 1px solid #e9ecef;
            }

            /* Responsive adjustments */
            @media (max-width: 768px) {
                  body {
                        padding: 15px;
                  }

                  .file-manager-container {
                        padding: 20px;
                  }

                  .card-img-container {
                        height: 140px;
                  }
            }

            @media (max-width: 576px) {
                  .card-img-container {
                        height: 120px;
                  }

                  .search-container {
                        max-width: 100%;
                  }
            }
      </style>
</head>

<body>
      <div class="container-fluid ">
            <div class="file-manager-container">
                  <!-- Header Section -->
                  <div class="header-section">
                        <h1 class="page-title">File Manager</h1>
                        <form action="{{ route('file-manager.upload') }}" method="POST" enctype="multipart/form-data"
                              class="upload-form mb-2">
                              @csrf
                              <div class="row">
                                    <div class="col-3 col-md-4 col-sm-12">
                                          <div class="search-container">

                                                <div class="input-group search-bar">
                                                      <input type="text" class="form-control pr-3" placeholder="title"
                                                            aria-label="Search files" id="fileInput" name="title">
                                                </div>

                                          </div>
                                    </div>

                                    <div class="col-4 col-md-4 col-sm-12">
                                          <div class="search-container">
                                                <div class="input-group search-bar">
                                                      <input type="file" class="form-control"
                                                            placeholder="Input files..." aria-label="Search files"
                                                            id="fileInput" name="file" required>
                                                      <button class="btn btn-primary" type="submit" id="searchButton">
                                                            <i class="bi bi-upload me-2"></i>Upload
                                                      </button>

                                                </div>

                                          </div>
                                    </div>

                              </div>
                        </form>

                        <div class="row">
                              <div class="search-container">
                                    <form action="" method="get">
                                          <div class="input-group search-bar">
                                                <input type="text" class="form-control" placeholder="Search files..."
                                                      aria-label="Search files" id="searchInput" name="search">
                                                <button class="btn btn-primary" type="submit" id="searchButton">
                                                      <i class="bi bi-search me-2"></i>Search
                                                </button>

                                          </div>
                                    </form>
                              </div>

                        </div>
                  </div>

                  <!-- Files Gallery -->
                  <div
                        class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 row-cols-xxl-6 g-4">
                        <!-- File 1 -->

                        @foreach($files as $file)
                              <div class="col">
                                    <div class="card h-100 file-card">
                                          <div class="card-img-container">
                                                <img src="{{ $file->url }}" class="card-img-top img-fluid"
                                                      style="height:200px; object-fit:cover;"
                                                      alt="{{ $file->title ?? 'file' }}">

                                          </div>
                                          <div class="card-body">
                                                <h6 class="card-title">{{ $file->title ?? 'file' }}</h6>
                                                <button type="button" class="btn use-file-btn text-white"
                                                      onclick="selectFile('{{ $file->url }}')">
                                                      <i class="bi bi-file-earmark-arrow-up me-1"></i> Use File
                                                </button>
                                          </div>
                                    </div>
                              </div>
                        @endforeach

                  </div>

                  <div class="card-body mt-5 row justify-content-center">
                        {{ $files->links() }}
                  </div>
            </div>
      </div>

      <!-- Bootstrap 5 JS Bundle -->
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

      <!-- Your existing JavaScript logic -->
      <script>
            const searchInput = document.getElementById('searchInput');
            const searchButton = document.getElementById('searchButton');

            searchButton.addEventListener('click', () => {
                  const query = searchInput.value.trim();
                  if (query) {
                        window.location.href = `?search=${encodeURIComponent(query)}`;
                  }
            });

            function selectFile(url) {
                  if (window.opener && !window.opener.closed) {
                        const input = window.opener.document.querySelector('.file-url-input');
                        if (input) {
                              input.value = url;
                        }
                        window.close();
                  } else {
                        alert('File URL: ' + url);
                  }
            }
      </script>

      <script>
            function selectFile(url) {

                  const params = new URLSearchParams(window.location.search);
                  const funcNum = params.get('CKEditorFuncNum');
                  const editorName = params.get('CKEditor');
                  const inputId = params.get('input');

                  // ✅ CKEditor Image dialog (URL field)
                  if (funcNum && window.opener) {
                        window.opener.CKEDITOR.tools.callFunction(funcNum, url);
                        window.close();
                        return;
                  }

                  // ✅ CKEditor fallback (editor insert)
                  if (editorName && window.opener && window.opener.CKEDITOR) {
                        const editor = window.opener.CKEDITOR.instances[editorName];
                        if (editor) {
                              editor.insertHtml('<img src="' + url + '" alt="">');
                        }
                        window.close();
                        return;
                  }

                  // ✅ Normal input field support
                  if (inputId && window.opener && !window.opener.closed) {

                        const input = window.opener.document.getElementById(inputId);
                        const preview = window.opener.document.getElementById('preview-' + inputId);

                        if (input) input.value = url;

                        if (preview) {
                              preview.src = url;
                              preview.style.display = 'block';
                        }

                        // Also send postMessage for enhanced integration
                        window.opener.postMessage({
                              type: 'file-selected',
                              fileUrl: url,
                              inputId: inputId
                        }, '*');

                        window.close();
                  }
            }
      </script>


      <script>
            // Toastr options
            toastr.options = {
                  "closeButton": true,
                  "progressBar": true,
                  "positionClass": "toast-top-right",
                  "timeOut": "5000"
            };

            // Laravel session messages
            @if(session('success'))
                  toastr.success("{{ session('success') }}");
            @endif

            @if(session('error'))
                  toastr.error("{{ session('error') }}");
            @endif
      </script>
</body>

</html>