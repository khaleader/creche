<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>3D Gallery Room</title>
    <meta name="description" content="Add a description" />
    <meta name="keywords" content="Add keywords" />
    <link rel="shortcut icon" type="image/png"  href="{{ asset('favicon.png') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('js\codrops\galleryRoom3D\css\default.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('js\codrops\galleryRoom3D\css\component2.css') }}" />
    <script src="{{ asset('js\codrops\galleryRoom3D\js\modernizr.custom.js') }}"></script>
</head>
<body>
<div class="container">
    <!-- Codrops top bar -->


    <div id="gr-gallery" class="gr-gallery">
        <div class="gr-main">
            <figure>
                <div>
                    <img src="{{ asset('js\codrops\galleryRoom3D\images\12.jpg') }}" alt="img02" />
                </div>
                <figcaption>
                    <h2><span>American Museum of Natural History #1</span></h2>
                    <div><p>New York City, 2009, by <a href="http://www.flickr.com/photos/thomasclaveirole">Thomas Claveirole</a></p></div>
                </figcaption>
            </figure>
            <figure>
                <div>
                    <img src="{{ asset('js\codrops\galleryRoom3D\images\13.jpg') }}" alt="img03" />
                </div>
                <figcaption>
                    <h2><span>NYC Marathon in Harlem #4</span></h2>
                    <div><p>New York City, 2009, by <a href="http://www.flickr.com/photos/thomasclaveirole">Thomas Claveirole</a></p></div>
                </figcaption>
            </figure>
            <figure>
                <div>
                    <img src="{{ asset('js\codrops\galleryRoom3D\images\15.jpg') }}" alt="img01" />
                </div>
                <figcaption>
                    <h2><span>SoHo</span></h2>
                    <div><p>New York City, 2009, by <a href="http://www.flickr.com/photos/thomasclaveirole">Thomas Claveirole</a></p></div>
                </figcaption>
            </figure>
            <figure>
                <div>
                    <img src="{{ asset('js\codrops\galleryRoom3D\images\16.jpg') }}" alt="img02" />
                </div>
                <figcaption>
                    <h2><span>Manhattan Downtown/Wall St. Heliport</span></h2>
                    <div><p>New York City, 2009, by <a href="http://www.flickr.com/photos/thomasclaveirole">Thomas Claveirole</a></p></div>
                </figcaption>
            </figure>
            <figure>
                <div>
                    <img src="{{ asset('js\codrops\galleryRoom3D\images\17.jpg') }}" alt="img03" />
                </div>
                <figcaption>
                    <h2><span>Musée National du Moyen Âge</span></h2>
                    <div><p>Paris, 2009, by <a href="http://www.flickr.com/photos/thomasclaveirole">Thomas Claveirole</a></p></div>
                </figcaption>
            </figure>
            <figure>
                <div>
                    <img src="{{ asset('js\codrops\galleryRoom3D\images\18.jpg') }}" alt="img08" />
                </div>
                <figcaption>
                    <h2><span>Métro Jussieu</span></h2>
                    <div><p>Paris, 2009, by <a href="http://www.flickr.com/photos/thomasclaveirole">Thomas Claveirole</a></p></div>
                </figcaption>
            </figure>
            <figure>
                <div>
                    <img src="{{ asset('js\codrops\galleryRoom3D\images\19.jpg') }}" alt="img09" />
                </div>
                <figcaption>
                    <h2><span>Rose Main Reading Room, New York Public Library</span></h2>
                    <div><p>New York City, 2009, by <a href="http://www.flickr.com/photos/thomasclaveirole">Thomas Claveirole</a></p></div>
                </figcaption>
            </figure>
            <figure>
                <div>
                    <img src="{{ asset('js\codrops\galleryRoom3D\images\20.jpg') }}" alt="img10" />
                </div>
                <figcaption>
                    <h2><span>Midtown Manhattan</span></h2>
                    <div><p>New York City, 2009, by <a href="http://www.flickr.com/photos/thomasclaveirole">Thomas Claveirole</a></p></div>
                </figcaption>
            </figure>
        </div>
    </div>
</div><!-- /container -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script src="{{ asset('js\codrops\galleryRoom3D\js\wallgallery.js') }}"></script>
<script>
    $(function() {

        Gallery.init( {
            layout : [3,2,3,2]
        } );

    });
</script>
</body>
</html>
