const second_form = document.querySelector('.agileits-top-second')
const buttons = document.querySelector('.agileits-top-third')
const titlePart = document.querySelector('.titlePart')


const array = [
  'first_name',
  'last_name',
  'birthday',
  'report_subject',
  'country',
  'phone',
  'email',
  'company',
  'position',
  'about_me'
]

const arrayLabels = []
for (const item in array) {
  arrayLabels[array[item]] = document.getElementById(array[item] + '_label').innerHTML
}



$('.iti.iti--allow-dropdown')[0].style.width = '100%'
$('.iti.iti--allow-dropdown')[0].style.marginBottom = '13px'
$('.iti.iti--allow-dropdown')[1].style.width = '100%'

if ($.session.get('data') == 'second_part') {
  $('#agileits-top-first').hide()
  second_form.style.display = ''
} else {
  second_form.style.display = 'none'
}

$('#first-form').submit(
  function () {
    for (const item in array) {
      const label = document.getElementById(array[item] + '_label')
      const html = arrayLabels[array[item]]
      label.style.color = 'floralwhite'
      label.innerHTML = html
      document.getElementById(array[item]).style.border = ''
    }

    $.post(
      '/save', // адрес обработчика
      $('#first-form').serialize(), // отправляемые данные
      function (msg) {
        // получен ответ сервера

        if (msg.length == 0) {
          $('#first-form').hide('slow')
          $('#agileits-top-first').hide('slow')
          second_form.style.display = ''
          $.session.set('data', 'second_part')
          console.log(msg)
        } else {
          const fields = JSON.parse(msg)
          for (const key in fields) {
            if (document.getElementById(key).value == '') {
              document.getElementById(key + '_label').innerHTML = 'These field cannot be empty!'
              document.getElementById(key + '_label').style.color = 'red'
            }
            document.getElementById(key + '_label').style.color = 'red'
            document.getElementById(key + '_label').innerHTML = fields[key]
            document.getElementById(key).style.border = 'red solid 1px'
          }
        }
      }
    )
    return false
  }
)

let files // переменная. будет содержать данные файлов

// заполняем переменную данными, при изменении значения поля file
$('input[type=file]').on(
  'change', function () {
    files = this.files
  }
)

$('#second-form').submit(
  function (e) {
    e.preventDefault()

    for (const item in array) {
      const label = document.getElementById(array[item] + '_label')
      const html = arrayLabels[array[item]]
      label.style.color = 'floralwhite'
      label.innerHTML = html
      document.getElementById(array[item]).style.border = ''
    }

    // создадим объект данных формы
    const data = new FormData(document.querySelector('.second-form'))
    $.each(
      files, function (key, value) {
        data.append(key, value)
      }
    )
    data.append('my_file_upload', 1)
    data.append('id', 1)

    $.ajax(
      {
        type: 'POST',
        url: '/image',
        data,
        cache: false,
        dataType: 'json',
        contentType: false,
        processData: false,
        success: function () {
          $.post(
            '/save', // адрес обработчика
            $('#second-form').serialize(), // отправляемые данные
            function (msg) {
              // получен ответ сервера

              if (msg.length == 0) {
                $('#first-form').hide()
                $('#agileits-top-first').hide()
                $('#second-form').hide('slow')
                $('#agileits-top-second').hide('slow')
                $.session.clear()
                buttons.style.display = 'block'
                titlePart.style.display = 'none'
              } else {
                const fields = JSON.parse(msg)
                for (const key in fields) {
                  if (document.getElementById(key).value == '') {
                    document.getElementById(key + '_label').innerHTML = 'These field cannot be empty!'
                    document.getElementById(key + '_label').style.color = 'red'
                  }
                  document.getElementById(key + '_label').style.color = 'red'
                  document.getElementById(key + '_label').innerHTML = fields[key]
                  document.getElementById(key).style.border = 'red solid 1px'
                }
              }
            }
          )
          return false
        }
      }
    )
  }
)
