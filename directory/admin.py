from django.contrib import admin
from .models import Insurance, Insurer, Service, Hospital, ICD
admin.site.register(Insurance)
admin.site.register(Insurer)
admin.site.register(Service)
admin.site.register(Hospital)
admin.site.register(ICD)

