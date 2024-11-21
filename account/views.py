import uuid 
from django.views.generic.base import View
from django.shortcuts import redirect
from django.views import generic
from django.contrib.auth import views as auth_views
from django.contrib.auth import authenticate, login
from django.urls import reverse_lazy

from .forms import RegisterForm
from customer_management.models import CustomerInsurance
from customer_management.forms import CustomerForm
from customer_management.api.services import create_customer,\
    create_contract_customer, get_customer_insurances
from directory.models import Insurance


class IdentifyRole(View):

    def get(self, request, *args, **kwargs):
        if request.user.role == 1:
            return redirect('customer_personal_cabinet:index')
        elif request.user.role == 2:
            return redirect('customer_personal_cabinet:index')
        elif request.user.role == 3:
            return redirect('report_management:invoice_report_list')


class AuthMixin:

    def user_auth(self):
        username = self.request.POST['username']
        password = self.request.POST['password1']
        user = authenticate(username=username, password=password)
        login(self.request, user)
        return True


class RegisterView(AuthMixin, generic.CreateView):
    form_class = RegisterForm
    customer_form_class = CustomerForm
    template_name = 'accounts/signup.html'
    success_url = reverse_lazy('customer_personal_cabinet:index')

    def get_context_data(self, **kwargs):
        context = super().get_context_data(**kwargs)
        context['customer_form'] = self.customer_form_class()
        return context

    def post(self, request, *args, **kwargs):
        form = self.form_class(request.POST)
        customer_form = self.customer_form_class(request.POST)
        if form.is_valid() and customer_form.is_valid():
            instance = form.save(commit=False)
            customer_obj = customer_form.save()
            instance.customer = customer_obj
            instance.save()
            self.user_auth()
            customer = create_customer('STATE', request.POST)
            number = uuid.uuid4().hex[:6].upper()
            data = {
                'customer': customer.get('id'),
                'number': number,
                'begin_date': '2022-11-26',
                'end_date': '2023-11-26',
                'type_holder': 1,
                'contract': 18,
                'program': 93
            }
            contract_customer = create_contract_customer('STATE', data)
            customer_insurances = get_customer_insurances(
                'PASASIGORTA', request.POST.get('iin'))
            for customer_insurance in customer_insurances:
                insurance = Insurance.objects.get(code='PASASIGORTA')
                contract = customer_insurance.get('contract')
                CustomerInsurance.objects.create(
                    customer=customer_obj,
                    card_number=customer_insurance.get('number'),
                    insurance=insurance,
                    insurer=contract.get('insurer'),
                    program=customer_insurance.get('program'),
                    begin_date=customer_insurance.get('begin_date'),
                    end_date=customer_insurance.get('end_date'),
                    limit=customer_insurance.get('limit_sum'),
                    invoice_sum=customer_insurance.get('invoice_sum')
                )
            return redirect('customer_personal_cabinet:index')
        else:
            return self.render_to_response({
                'form': form,
                'customer_form': customer_form
            })

