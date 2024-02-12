from django.db import models
from directory.models import Insurance


# Клиент
class Customer(models.Model):
    GENDER_CHOICES = [
        ('Мужчина', 'Мужчина'),
        ('Женщина', 'Женщина')
    ]
    first_name = models.CharField(max_length=180)
    last_name = models.CharField(max_length=180)
    surname = models.CharField(max_length=180, null=True, blank=True)
    iin = models.CharField(max_length=13, unique=True)
    gender = models.CharField(max_length=180, choices=GENDER_CHOICES, null=True, blank=True)
    national = models.CharField(max_length=180, null=True, blank=True)
    address = models.CharField(max_length=180, null=True, blank=True)
    place_work = models.CharField(max_length=180, null=True, blank=True)
    telephone_number = models.CharField(max_length=180, null=True, blank=True)
    profession = models.CharField(max_length=180, null=True, blank=True)
    birthday = models.DateField(null=True, blank=True)
    passport_number = models.CharField(max_length=180, null=True, blank=True)

    @property
    def full_name(self):
        return "{} {}".format(
            self.last_name, self.first_name)

    def __str__(self):
        return "ИИН: {}, ФИО: {} {}".format(
            self.iin, self.last_name, self.first_name)


# Страховка клиента
class CustomerInsurance(models.Model):
    PAY_TYPE_CHOICES = [
        (1, 'ДМС индивидуальный'),
        (2, 'ОМС/ДМС перестраховочные')
    ]
    customer = models.ForeignKey(Customer, on_delete=models.CASCADE, related_name='customer_insurance')
    insurance = models.ForeignKey(Insurance, on_delete=models.CASCADE)
    card_number = models.CharField(max_length=180, unique=True)
    insurer = models.CharField(max_length=320)
    program = models.CharField(max_length=320)
    begin_date = models.DateField()
    end_date = models.DateField()
    limit = models.CharField(max_length=320)
    invoice_sum = models.CharField(max_length=320)
    pay_type = models.IntegerField(choices=PAY_TYPE_CHOICES, default=1)

    def __str__(self):
        return self.card_number




