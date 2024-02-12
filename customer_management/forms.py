from django import forms
from crispy_forms.helper import FormHelper
from .models import Customer


class CustomerForm(forms.ModelForm):

    def __init__(self, *args, **kwargs):
        super().__init__(*args, **kwargs)
        self.helper = FormHelper()
        self.helper.form_tag = False

    class Meta:
        model = Customer
        fields = ['first_name', 'last_name', 'iin', 'gender',
            'birthday', 'passport_number', 'address', 'telephone_number'
        ]

        labels = {
            'last_name': 'Фамилия: ',
            'first_name': 'Имя:',
            'iin': 'ФИИН:',
            'gender': 'Пол',
            'birthday': 'День рождения',
            'passport_number': 'Номер паспорта',
            'address': 'Адрес проживания',
            'telephone_number': 'Номер телефона',
        }
        widgets = {
            'birthday': forms.TextInput(attrs={'type': 'date'}),

        }
        verbose_name = 'Пациент'
        verbose_name_plural = 'Пациенты'