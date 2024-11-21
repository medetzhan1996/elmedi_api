from django.contrib.auth.forms import UserCreationForm, AuthenticationForm
from django.contrib.auth import get_user_model
from django import forms

from crispy_forms.helper import FormHelper

from .models import User

UserModel = get_user_model()


class RegisterForm(UserCreationForm):
    role = forms.IntegerField(widget=forms.HiddenInput())

    def __init__(self, *args, **kwargs):
        super().__init__(*args, **kwargs)
        self.helper = FormHelper()
        self.helper.form_tag = False
        del self.fields['password2']

    class Meta:
        model = UserModel
        fields = ['username', 'email', 'role']

        labels = {
            'username': 'Введите ваш логин*',
            'email': 'Введите адрес электронной почты',
            'password1': 'Создать пароль',
            'password': 'пароль'
        }

    def save(self, commit=True):
        user = super(UserCreationForm, self).save(commit=False)
        user.set_password(self.cleaned_data["password1"])
        user.role = self.cleaned_data["role"]
        user.is_active = True
        if commit:
            user.save()
        return user
