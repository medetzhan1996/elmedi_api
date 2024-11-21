import uuid 
from django.http import JsonResponse
from django.views.generic.base import TemplateResponseMixin
from django.views.generic.base import View
from django.views.generic import TemplateView
from django.contrib.auth.mixins import LoginRequiredMixin
from django.views.generic.list import ListView

from referral_management.api.services import create_referral
from .models import Doctor, DoctorTimetable, PayProgram
from .api.services import get_services, get_programs
from directory.models import Hospital, Service, ICD
from referral_management.models import Referral
from referral_management.forms import ReferralForm
from customer_management.api.services import create_customer, create_contract_customer, get_customer

# from customer_management.api.services import get_customer_insurances
from customer_management.models import CustomerInsurance
from invoice_management.models import Invoice
from document_management.models import AttachedDocument


# Главная страница
class IndexView(LoginRequiredMixin, TemplateView):
    template_name = 'customer_personal_cabinet/index.html'

    def get_context_data(self, *args, **kwargs):
        context = super().get_context_data(*args, **kwargs)
        context['appointment'] = self.request.GET.get('appointment', None)
        return context


# Список страховых карт клиента
class InsuranceListView(LoginRequiredMixin, ListView):
    template_name = 'customer_personal_cabinet/insurance/list.html'
    model = CustomerInsurance
    context_object_name = 'customer_insurances'

    def get_queryset(self):
        qs = super().get_queryset()
        customer = self.request.user.customer
        return qs.filter(customer=customer)


# Список больниц
class HospitalListView(LoginRequiredMixin, TemplateResponseMixin, View):
    template_name = 'customer_personal_cabinet/hospital/list.html'

    def get(self, request, *args, **kwargs):
        customer_insurances = self.request.user.customer.customer_insurance.all()
        return self.render_to_response({'customer_insurances': customer_insurances})


# Услуги больницы
class HospitalServiceListView(LoginRequiredMixin, TemplateResponseMixin, View):
    template_name = 'customer_personal_cabinet/hospital_service/list.html'
    model = Service
    context_object_name = 'hospital_services'

    def get(self, request, *args, **kwargs):
        hospital_code = self.kwargs.get('hospital_code')
        card_number = self.kwargs.get('card_number')
        customer_insurance = CustomerInsurance.objects.get(card_number=card_number)
        hospital = Hospital.objects.get(code=hospital_code)
        insurance_code = customer_insurance.insurance.code
        hospital_services = get_services(
            insurance_code=insurance_code, card_number=card_number,
            hospital=hospital_code, type_appeal=type_appeal
        )
        return self.render_to_response({'hospital_services': hospital_services,
                                         'hospital': hospital, 'card_number': card_number})


# Способ записи на прием
class AppointmentMethodListView(LoginRequiredMixin, TemplateView):
    template_name = 'customer_personal_cabinet/appointment_method/list.html'

    def get_context_data(self, *args, **kwargs):
        context = super().get_context_data(*args, **kwargs)
        context['hospital'] = self.kwargs.get('hospital')
        context['service'] = self.kwargs.get('service')
        return context


# Список докторов больницы
class DoctorListView(LoginRequiredMixin, ListView):
    template_name = 'customer_personal_cabinet/doctor/list.html'
    model = Doctor

    def get_context_data(self, *args, **kwargs):
        type_appeal = self.request.GET.get('type_appeal', '')
        status = self.request.GET.get('status', None)
        
        context = super().get_context_data(*args, **kwargs)
        card_number = None
        services = []
        doctors = []
        my_hospitals = []
        hospital_code = self.kwargs.get('hospital_code', None)
        service_code = self.kwargs.get('service_code', None)
        card_number = self.kwargs.get('card_number', None)
        if status:
            my_hospitals = Hospital.objects.filter(status=status).all()
        if hospital_code:
            customer_insurance = CustomerInsurance.objects.get(card_number=card_number)
            hospital = Hospital.objects.get(code=hospital_code)
            insurance_code = customer_insurance.insurance.code
            services = get_services(
                insurance_code=insurance_code, card_number=card_number, hospital=hospital_code
            )
            doctors = Doctor.objects.filter(hospital__code=hospital_code).all()
            if service_code:
                service = Service.objects.get(code=service_code)
                doctors = doctors.filter(services__in=[service])
        context['customer_insurances'] = self.request.user.customer.customer_insurance.all()
        context['services'] = services
        context['hospital_code'] = hospital_code
        context['doctors'] = doctors
        context['card_number_code'] = card_number
        context['service_code'] = service_code
        context['type_appeal'] = type_appeal
        context['status'] = status
        context['my_hospitals'] = my_hospitals
        
        
        return context



class DoctorAppointmentListView(TemplateResponseMixin, View):
    template_name = 'customer_personal_cabinet/doctor_appointment/list.html'

    def get(self, request, *args, **kwargs):
        times = [
            '08:00', '08:30', '09:00',
            '09:30', '10:00', '10:30',
            '11:00', '11:30', '12:00',
            '12:30', '13:00', '13:30',
            '14:00', '14:30', '15:00',
            '15:30', '16:00', '16:30', 
            '17:00', '17:30', '18:00'
        ]
        date = request.GET.get('date')
        doctor = kwargs.get('doctor')
        return self.render_to_response(
            {'times': times, 'doctor': doctor, 'date': date})


class DoctorAppointmentCreateView(View):

    def post(self, request, *args, **kwargs):
        contract_customer = request.POST.get('customer_insurance')
        sending_hospital = Hospital.objects.get(code=request.POST.get('sending_hospital'))
        directed_hospital = Hospital.objects.get(code=request.POST.get('directed_hospital'))
        icd = ICD.objects.get(code='T14.9')
        service = Service.objects.get(code=request.POST.get('service'))
        type_appeal = request.POST.get('type_appeal')
        doctor = request.POST.get('doctor')
        place = request.POST.get('place')
        date = request.POST.get('date')
        time = request.POST.get('time')
        doctor_full_name= request.POST.get('doctor_full_name', '')
        customer_insurance = CustomerInsurance.objects.get(card_number=contract_customer)
        customer = customer_insurance.customer
        insurance_code = customer_insurance.insurance.code
        Referral.objects.create(
            customer=customer,
            sending_hospital=sending_hospital,
            directed_hospital=directed_hospital,
            type_appeal=type_appeal,
            place=place,
            service=service,
            icd=icd,
            date=date,
            customer_insurance=customer_insurance,
            performing_doctor=doctor_full_name,
            doctor_full_name=doctor_full_name,
            time=time
        )
        DoctorTimetable.objects.create(
            doctor_id=doctor,
            date=date,
            time=time
        )
        data = {**request.POST, 'customer': customer_insurance.customer.iin}
        create_referral(insurance_code, data)
        return JsonResponse({'success': True})


class SignaturesView(TemplateResponseMixin, View):
    template_name = 'customer_personal_cabinet/signatures.html'

    def get(self, request, *args, **kwargs):
        return self.render_to_response({})


class ServicesView(TemplateResponseMixin, View):
    template_name = 'customer_personal_cabinet/services.html'

    def get(self, request, *args, **kwargs):
        context = {}
        customer = request.user.customer
        customer_insurance = CustomerInsurance.objects.filter(customer=customer).first()
        context['customer'] = customer
        context['customer_insurance'] = customer_insurance
        context['referrals'] = Referral.objects.filter(customer=customer).all()
        context['invoices'] = Invoice.objects.filter(customer=customer).all()
        return self.render_to_response(context)


class AttachedDocumentView(TemplateResponseMixin, View):
    template_name = 'customer_personal_cabinet/attached_document.html'

    def get(self, request, *args, **kwargs):
        customer = request.user.customer
        customer_insurance = CustomerInsurance.objects.filter(customer=customer).first()
        attached_documents = AttachedDocument.objects.filter(
            customer=customer).values('title', 'customer', 'invoice', 'uploaded_at', 'id')
        customer_insurance = customer_insurance
        referrals = Referral.objects.filter(customer=customer).all()
        invoices = Invoice.objects.filter(customer=customer).all()
        return self.render_to_response({
            'attached_documents': attached_documents,
            'customer': customer,
            'customer_insurance': customer_insurance,
            'referrals': referrals,
            'invoices': invoices
        })


class AttachedDocumentDetailView(TemplateResponseMixin, View):
    template_name = 'customer_personal_cabinet/attached_document_detail.html'

    def get(self, request, *args, **kwargs):
        attached_document = AttachedDocument.objects.get(pk=kwargs.get('pk'))
        return self.render_to_response({
            'attached_document': attached_document
        })


class PayProgramListView(TemplateResponseMixin, View):
    template_name = 'customer_personal_cabinet/pay_program_list.html'

    def get(self, request, *args, **kwargs):
        context = {}
        customer = request.user.customer
        customer_insurance = CustomerInsurance.objects.filter(customer=customer).first()
        programs = get_programs(
            insurance_code='DEFAULT'
        )
        state_programs = get_programs(
            insurance_code='DEFAULT'
        )
        kazimova_programs = get_programs(
            insurance_code='DEFAULT'
        )
        return self.render_to_response({
            'programs': programs,
            'state_programs': state_programs,
            'kazimova_programs': kazimova_programs
            })

    def post(self, request, *args, **kwargs):
        contract = request.POST.get('contract')
        program = request.POST.get('program')
        hospital_code = request.POST.get('hospital_code')
        pay_type = str(request.POST.get('pay_type'))
        customer = request.user.customer
        iin = customer.iin
        api_customer = get_customer(hospital_code, iin)
        customer_id = api_customer.get('id', None)
        if not customer_id:
            json_data = {
                'first_name': customer.first_name,
                'last_name': customer.last_name,
                'iin': iin
            }
            api_customer = create_customer(hospital_code, json_data)
            customer_id = api_customer.get('id')
        number = uuid.uuid4().hex[:6].upper()
        data = {
            'customer': customer_id,
            'number': number,
            'begin_date': '2022-10-26',
            'end_date': '2023-10-26',
            'type_holder': 1,
            'contract': contract,
            'program': program
        }
        contract_customer = create_contract_customer(hospital_code, data)
        PayProgram.objects.create(iin=iin, contract=contract, program=program)
        return JsonResponse({'success': True})

class PayProgramContractView(TemplateResponseMixin, View):
    template_name = 'customer_personal_cabinet/contract.html'

    def get(self, request, *args, **kwargs):
        context = {}
        pk = kwargs.get('pk')
        customer = request.user.customer
        customer_insurance = CustomerInsurance.objects.filter(customer=customer).first()
        programs = get_programs(
            insurance_code='MARKEZICLINIK'
        )
        return self.render_to_response({'programs': programs,
            'pk': pk, 'customer_insurance': customer_insurance})