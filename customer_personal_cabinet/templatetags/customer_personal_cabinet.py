from datetime import datetime, timedelta
from django import template
from customer_personal_cabinet.api.services import get_available_hospitals, get_contract_customer
from customer_personal_cabinet.models import DoctorTimetable, PayProgram, DoctorOutsideTimetable


register = template.Library()


@register.simple_tag
def get_hospitals(insurance_code, card_number):
    return get_available_hospitals(insurance_code, card_number)


@register.simple_tag
def is_selected(val_1, val_2):
    if str(val_1) == str(val_2):
        return 'selected'
    return ''


@register.simple_tag
def is_free_time(doctor, date, time):
    date_time = date + ' ' + time
    given_datetime = datetime.strptime(date_time, '%Y-%m-%d %H:%M')
    week = given_datetime.weekday()
    final_time = given_datetime + timedelta(minutes=29)
    doctor_outside_timetable_exists = DoctorOutsideTimetable.objects.filter(
        doctor=doctor, start_time__lte=given_datetime.time(),
        end_time__gte=given_datetime.time(), week=week).exists()
    if doctor_outside_timetable_exists:
        return False
    doctor_timetable_exists = DoctorTimetable.objects.filter(
        doctor=doctor, date=date, time__gte=time, time__lte=final_time.time()).exists()
    if doctor_timetable_exists:
        return False
    return True


@register.simple_tag
def get_of_unique_dicts(dict):
    result = {x['hospital__code']:x for x in dict}.values()
    return result


@register.simple_tag
def check_pay_program(contract, program, iin):
    return PayProgram.objects.filter(contract=contract, program=program, iin=iin).exists()

@register.simple_tag
def get_contract_customer_tag(insurance_code, card_number):
    return get_contract_customer(insurance_code, card_number)
