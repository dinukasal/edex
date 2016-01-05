{{ HTML::style('css/test.css')}}
<div class="bs-example" data-example-id="basic-forms" style="position:absolute;top:100px;left:30%;width:500px;height:auto">
<form method="post" action="/getdata">
  <div class="form-group">
    <label for="">Request</label>
    <input type="text" class="form-control" id="request" name="request" placeholder="request">
  </div>
  <div class="form-group">
    <label for="">Issue</label>
    <input type="text" class="form-control" id="issue" name="issue" placeholder="issue">
  </div>
  <div class="form-group">
    <label for="">Article</label>
    <input type="text" class="form-control" id="article" name="article" placeholder="article">
  </div>


  <!--div class="form-group">
    <label for="exampleInputEmail1">Email address</label>
    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
  </div>
  <div class="form-group">
    <label for="exampleInputFile">File input</label>
    <input type="file" id="exampleInputFile">
    <p class="help-block">Example block-level help text here.</p>
  </div>
  <div class="checkbox">
    <label>
      <input type="checkbox"> Check me out
    </label>
  </div-->
  <button type="submit" class="btn btn-default">Submit</button>
</form>
</div>
