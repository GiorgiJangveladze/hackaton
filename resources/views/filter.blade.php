<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        </style>
    </head>
    <body>
      <form action="{{ route('connection') }}" method="GET">

        <div class="col-md-3">
          <div class="form-group">
            <select id="persons" name="person_id" class="select-select2-persons">
              {{-- @if($filter['person'])
                <option value="{{ $filter['person']->id }}">{{ $filter['person']->name }}</option>
              @endif --}}
              <option value=""></option>
            </select>
          </div>
        </div>
        
        <div class="col-md-3">
          <div class="form-group">
            <select id="factoidTypes" name="factoid_type_id" class="select-select2-factoid-types">
              {{-- @if($filter['factoidType'])
                <option value="{{ $filter['factoidType']->id }}">{{ $filter['factoidType']->name }}</option>
              @endif --}}
            </select>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <input type="text" class="form-control" placeholder="ძებნა..." name="year">
          </div>
        </div>

        <div class="col-xs-12 text-right">
          <div class="form-group">
            <button class="btn btn-primary" type="button" id="reset-search-form"><i
                class="fa fa-refresh"></i> Reset
            </button>
            <button class="btn btn-primary" type="submit"><i
                class="fa fa-search"></i> Search
            </button>
          </div>
        </div>
      </form>

    </body>
<script src="js/vendor/jquery.min.js"></script>
<script src="js/vendor/bootstrap.min.js"></script>
{{-- <script src="js/classes/Modal.js"></script> --}}
<script src="js/plugins.js"></script>
  <script>
        $('.select-select2-persons').select2({
        minimumInputLength: 2,
        placeholder: 'პირები...',
        ajax: {
          url: "{{ route('persons.filter') }}",
          dataType: 'json',
          delay: 250,
          data: function (term) {
            return term;
          },
          processResults: function (persons) {
            $.each(persons, function (k, person) {
              person.text = person.name;
            });
            return {results: persons};
          }
        }
      });

      $('.select-select2-factoid-types').select2({
        minimumInputLength: 2,
        placeholder: 'ფაქტის ტიპი...',
        ajax: {
          url: "{{ route('factoidType.filter') }}",
          dataType: 'json',
          delay: 250,
          data: function (term) {
            return term;
          },
          processResults: function (factoidType) {
            $.each(factoidType, function (k, factoidType) {
              factoidType.text = factoidType.name;
            });
            return {results: factoidType};
          }
        }
      });
  </script>
</html>
