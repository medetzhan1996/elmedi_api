from django.contrib import admin
from .models import Customer
from .models import CustomerInsurance

admin.site.register(Customer)
admin.site.register(CustomerInsurance)
