<!DOCTYPE html>
<html>
  <head>
    <title>Questions</title>
    <link
      rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
    />
    <style>
      body {
        background-color: #f7f7f7; /* gray background */
      }
      .container {
        max-width: 700px; /* set max width to 700px */
        margin: 40px auto; /* add margin for better layout */
        padding: 20px; /* add padding for better layout */
        background-color: #fff; /* white background for container */
        border: 1px solid #ddd; /* add border for better layout */
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* add box shadow for better layout */
      }
    </style>
  </head>
  <body>
    <div class="container mt-5">
        @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
         </div>  
        @endif
        @if ($errors->any())
       <div class="alert alert-danger" role="alert">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div>
     @endif
        <h1>Create new Question</h1>
      <form action="{{route('store.question')}}" method="POST">
        @csrf
        <div class="form-group">
          <label for="question">Question</label>
          <input
            type="text"
            class="form-control"
            id="question"
            name="question"
    
          />
        </div>
        <div class="form-group">
          <label for="option1">Option 1</label>
          <input
            type="text"
            class="form-control"
            id="optionOne"
            name="optionOne"
          />
        </div>
        <div class="form-group">
          <label for="optionTwo">Option 2</label>
          <input
            type="text"
            class="form-control"
            id="optionTwo"
            name="optionTwo"
          />
        </div>
        <div class="form-group">
            <label for="optionThree">Option 3</label>
            <input
              type="text"
              class="form-control"
              id="optionThree"
              name="optionThree"

            />
          </div>
          <div class="form-group">
            <label for="optionTwo">right answer</label>
            <input
              type="text"
              class="form-control"
              id="rightAnswer"
              name="rightAnswer"
            />
          </div>
          <div class="form-group">
            <label for="optionTwo">Level name</label>
            <input
              type="text"
              class="form-control"
              id="level"
              name="level"
              value="{{old('level')}}"
            />
          </div>
     
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>

    <script
      src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
      integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2/dist/umd/popper.min.js"
      integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
      crossorigin="anonymous">
    </script>
    <script
      src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
      integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV"
      crossorigin="anonymous"
    ></script>
  </body>
</html>