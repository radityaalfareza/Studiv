<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Profile</title>
</head>
<body>
    <div class="container">
        <div class="row pt-3">
            <div class="col col-2 border border-3 rounded-4 mb-3 d-flex flex-column custom-shadow" style="background-color: #9ACBD0; position: sticky; height: 95.1vh; top: 16px;">
                <button onclick="window.location.href='beranda.php'" type="button" class="btn btn-light p-2 mt-3" style="width: 100%;">Beranda</button>
                <button onclick="window.location.href='post.php'" type="button" class="btn btn-light p-2 mt-3" style="width: 100%;">Post</button>
                <button onclick="window.location.href='bookmark.php'" type="button" class="btn btn-light p-2 mt-3" style="width: 100%;">Bookmark</button>
                <div class="flex-grow-1"></div>
                <button onclick="window.location.href='profile.php'" type="button" class="btn btn-light p-2 mb-3 mt-auto" style="width: 100%;">Profil</button>
                <button onclick="window.location.href='setting.php'" type="button" class="btn btn-light p-2 mb-3 mt-auto" style="width: 100%;">Setting</button>
            </div>
            <div class="col postHead border border-3 rounded-4 p-3 mb-3 custom-shadow overflow-container" style="background-color: #ffffff; margin-left: 1%;">
                <div class="d-flex">
                    <img src="img/cato.png" class="rounded-5 pp" alt="img/.png">
                    <div class="d-flex flex-column ms-3">
                        <div> <p class="fw-bolder mb-1">Lorem</p> </div>
                        <div> <p>Created at 2025</p> </div>
                    </div>
                </div>
                <div class="row postBody mt-2">
                    <div class="col">
                        <p class="custom-heading fw-bolder">In incididunt ea laborum tempor deserunt reprehenderit.</p>
                        <p class="custom-heading fw-normal">Quis dolor pariatur est in elit nulla pariatur minim laboris consectetur. Ipsum et labore tempor et elit irure esse aliquip commodo voluptate aliquip laboris reprehenderit. In ut ad culpa id ea occaecat veniam eu excepteur esse. Id esse esse minim occaecat ea labore sit nisi. Esse deserunt qui laboris elit amet nostrud ad aliquip nisi id exercitation.</p>
                    </div>
                </div>
                <div class="row postFoot">
                    <div class="row d-flex justify-content-between align-items-center">
                        <div class="col-auto d-flex">
                            <button type="button" class="btn"> <img src="img/up-arrow.png" alt="Up" class="img-fluid" style="width: 30px; height: 30px;"> <p class="text-center my-auto ms-0">100</p> </button>
                            <button type="button" class="btn"> <img src="img/down-arrow.png" alt="Down" class="img-fluid" style="width: 30px; height: 30px;"> <p class="text-center my-auto ms-0">100</p> </button>
                            <button type="button" class="btn"> <img src="img/chat.png" alt="Chat" class="img-fluid" style="width: 30px; height: 30px;"> <p class="text-center my-auto ms-0">100</p> </button>
                        </div>
                        <div class="col-auto d-flex align-items-center">
                            <div class="save-button-wrapper me-2">
                                <button type="button" class="btn"> <img src="img/bookmark.png" alt="Save" class="img-fluid" style="width: 30px; height: 30px;"> <p class="text-center my-auto ms-0">Save</p> </button>
                            </div>
                            <button type="button" class="btn"> <img src="img/event.png" alt="Report" class="img-fluid" style="width: 30px; height: 30px;"> <p class="text-center my-auto ms-0">Report</p> </button>
                        </div>
                    </div>
                </div>
                <hr style="width: 100%; height: 2px; background-color: black; border: none; margin: 20px auto;">
                <!-- comment -->
                <div class="d-flex">
                    <img src="img/cato.png" class="rounded-5 pp" alt="img/.png">
                    <div class="d-flex flex-column ms-3">
                        <div> <p class="fw-bolder mb-1">Lorem • 2d ago</p> </div>
                        <div> <p>Voluptate fugiat eu occaecat aliqua laboris cupidatat ullamco mollit magna nulla magna irure culpa. Sit commodo cupidatat ut anim incididunt elit dolore laboris id Lorem pariatur ea do. Aliqua qui aliqua quis aute. Consectetur quis aute proident consequat aliqua. Non eiusmod enim non labore minim ullamco sit occaecat amet in occaecat commodo sit dolore. Occaecat et sunt irure magna nulla aliqua fugiat velit ea dolore tempor dolor.</p> </div>
                    </div>
                </div>
                <br>
                <!-- comment -->
                <div class="d-flex">
                    <img src="img/cato.png" class="rounded-5 pp" alt="img/.png">
                    <div class="d-flex flex-column ms-3">
                        <div> <p class="fw-bolder mb-1">Lorem • 2d ago</p> </div>
                        <div> <p>Voluptate fugiat eu occaecat aliqua laboris cupidatat ullamco mollit magna nulla magna irure culpa. Sit commodo cupidatat ut anim incididunt elit dolore laboris id Lorem pariatur ea do. Aliqua qui aliqua quis aute. Consectetur quis aute proident consequat aliqua. Non eiusmod enim non labore minim ullamco sit occaecat amet in occaecat commodo sit dolore. Occaecat et sunt irure magna nulla aliqua fugiat velit ea dolore tempor dolor.</p> </div>
                    </div>
                </div>
                <br>
                <!-- comment -->
                <div class="d-flex">
                    <img src="img/cato.png" class="rounded-5 pp" alt="img/.png">
                    <div class="d-flex flex-column ms-3">
                        <div> <p class="fw-bolder mb-1">Lorem • 2d ago</p> </div>
                        <div> <p>Voluptate fugiat eu occaecat aliqua laboris cupidatat ullamco mollit magna nulla magna irure culpa. Sit commodo cupidatat ut anim incididunt elit dolore laboris id Lorem pariatur ea do. Aliqua qui aliqua quis aute. Consectetur quis aute proident consequat aliqua. Non eiusmod enim non labore minim ullamco sit occaecat amet in occaecat commodo sit dolore. Occaecat et sunt irure magna nulla aliqua fugiat velit ea dolore tempor dolor.</p> </div>
                    </div>
                </div>
                <br>
            </div>
        </div>
    </div>

    <script>
        const textarea = document.getElementById('smartTextarea');
        const container = textarea.parentElement;
        const sibling = container.querySelector('.sibling');

        let lastValidHeight = textarea.clientHeight;

        textarea.addEventListener('mouseup', () => {
        // Allow time for resize to complete
        requestAnimationFrame(() => {
            const spaceAvailable = sibling.offsetTop - textarea.offsetTop - 10; // 10px padding buffer
            if (textarea.clientHeight > spaceAvailable) {
            textarea.style.height = `${lastValidHeight}px`;
            } else {
            lastValidHeight = textarea.clientHeight;
            }
        });
        });
    </script>
</body>
</html>