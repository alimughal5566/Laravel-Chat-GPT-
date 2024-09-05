<!DOCTYPE html>
<html lang="en">
<head>
    <title>Chat GPT Laravel</title>
    <link rel="icon" href="https://avatars.githubusercontent.com/u/70640438?v=4&size=64"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <!-- End JavaScript -->

    <!-- CSS -->
    <link rel="stylesheet" href="/style.css">
    <!-- End CSS -->

</head>

<body>
<div class="chat">

    <!-- Header -->
    <div class="top">
        <img src="https://avatars.githubusercontent.com/u/70640438?v=4&size=64" alt="Avatar">
        <div>
            <p>Muhammad Ali</p>
            <small>Online</small>
        </div>
    </div>
    <!-- End Header -->

    <!-- Chat -->
    <div class="messages">
        <div class="left message">
            <img src="https://avatars.githubusercontent.com/u/70640438?v=4&size=64" alt="Avatar">
            <p>Let's Play With AI !! </p>
        </div>
    </div>
    <!-- End Chat -->

    <!-- Footer -->
    <div class="bottom">
        <form>
            <input type="text" id="message" name="message" placeholder="Enter message..." autocomplete="off">
            <button type="submit"></button>
        </form>
    </div>
    <!-- End Footer -->

</div>
</body>

<script>
    //Broadcast messages
    $("form").submit(function (event) {
        event.preventDefault();

        //Stop empty messages
        if ($("form #message").val().trim() === '') {
            return;
        }

        //Disable form
        $("form #message").prop('disabled', true);
        $("form button").prop('disabled', true);

        $.ajax({
            url: "/chat_gpt",
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': "{{csrf_token()}}"
            },
            data: {
                "model": "gpt-3.5-turbo",
                "content": $("form #message").val()
            }
        }).done(function (res) {

            //Populate sending message
            $(".messages > .message").last().after('<div class="right message">' +
                '<p>' + $("form #message").val() + '</p>' +
                '<img src="https://avatars.githubusercontent.com/u/70640438?v=4&size=64" alt="Avatar">' +
                '</div>');

            //Populate receiving message
            $(".messages > .message").last().after('<div class="left message">' +
                '<img src="https://avatars.githubusercontent.com/u/70640438?v=4&size=64" alt="Avatar">' +
                '<p>' + res + '</p>' +
                '</div>');

            //Cleanup
            $("form #message").val('');
            $(document).scrollTop($(document).height());

            //Enable form
            $("form #message").prop('disabled', false);
            $("form button").prop('disabled', false);
        });
    });

</script>
</html>
