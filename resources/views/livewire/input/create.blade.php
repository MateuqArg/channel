<a data-bs-toggle="modal" data-bs-target="#create" class="btn btn-outline-light"><i class="bi bi-plus-lg"></i></a>

<div class="text-dark modal fade" id="create" tabindex="-1" aria-labelledby="createLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createLabel">Dar de alta campo</h5>
      </div>
      <div class="modal-body">
        <div class="form-check form-switch mb-4">
          <input class="form-check-input" type="checkbox" role="switch" id="new-btn">
          <label class="form-check-label" for="new-btn">Crear nuevo campo</label>
        </div>
        <div id="new" style="display: none;">
          <div class="mb-3">
            <label for="type" class="form-label">Tipo</label>
            <select id="type" class="form-control" required>
              <option value="title">Titulo</option>
              <option value="text">Texto</option>
              <option value="textarea">Parrafo</option>
              <option value="select">Selección</option>
              <option value="radio">Opciones</option>
              <option value="checkbox">Casillas de verificación</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="label" class="form-label">Etiqueta</label>
            <input type="text" id="label" class="form-control" aria-describedby="labelHelp" required>
          </div>
          <div id="subtitle" class="mb-3">
            <label for="subtitle" id="subtitleLabel" class="form-label">Subtitulo</label>
            <input type="text" id="subtitleInput" class="form-control">
          </div>
          <div id="optionsList" class="mb-3" style="display: none;">
            <label id="optionsListLabel" class="form-label">Opciones</label>
            <div id="optionsListInputs"></div>
            <div class="input-group mb-2">
                <input id="new-option" type="text" class="form-control" placeholder="Agregar una opción..." aria-label="Agregar una opción...">
              </div>
          </div>
        </div>
        <div id="search">
          <select id="input_id" class="form-control">
            <option disabled selected>Selecciona un campo</option>
            @foreach($inputs as $input)
              <option value="{{ $input->id }}">{{ "$input->label | $input->type" }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-arrow-left"></i></button>
        <button onclick="sendForm()" class="btn btn-success"><i class="bi bi-send"></i> ENVIAR</button>
      </div>
    </div>
  </div>
</div>

<script>
  function sendForm() {
    var type = $('#type').val();
    var label = $('#label').val();
    var options = $("input[name='options[]']")
              .map(function(){return $(this).val();}).get();
    var subtitle = $('#subtitleInput').val();

    if ($('#new-btn').prop("checked") == false) {
      var input_id = $('#input_id').val();
    }

    @this.emit('create', type, label, options, subtitle, input_id);
    $('#create').modal('hide');
    $('#create').removeData();
    $('#new-btn').prop("checked", false)
  }

  $('#new-btn').click(function () {
    if ($(this).prop("checked") == true) {
      $('#new').show();
      $('#search').hide();
    } else {
      $('#new').hide();
      $('#search').show();
    }
  });

  function delay(callback, ms) {
    var timer = 0;
    return function() {
      var context = this, args = arguments;
      clearTimeout(timer);
      timer = setTimeout(function () {
        callback.apply(context, args);
      }, ms || 0);
    };
  }

  let id = 0;
  $('#new-option').focus(delay(function (e) {
      var option = 
      '<div id="option-'+id+'" class="input-group mb-2"><input id="optionInput-'+id+'" data-id="'+id+'" name="options[]" type="text" class="form-control"><div class="input-group-append"><button class="btn btn-outline-danger" onclick="clearOption('+id+')" type="button"><i class="bi bi-x-lg"></i></button></div></div>';

      $(option).appendTo($('#optionsListInputs')).find('input:last').focus();

      var tmpStr = $('#optionInput-'+id).val();
      $('#optionInput-'+id)
      .val('')
      .val(tmpStr);

      $(this).val('');

      id = id + 1;
  }, 300));

  function clearOption(id) {
    $('#option-'+id).remove();
  }

  $('#type').change(function () {
    $('#subtitle').hide();
    $('#optionsList').hide();

    switch($(this).val()) {
      case 'title': 
        $('#subtitle').show();
        break;
      case 'text': 
        break;
      case 'textarea': 
        break;
      case 'select': 
        $('#optionsList').show();
        break;
      case 'radio': 
        $('#optionsList').show();
        break;
      case 'checkbox': 
        $('#optionsList').show();
        break;
    }
  });
</script>