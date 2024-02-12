from django.contrib import admin
from .models import Doctor, DoctorService, DoctorTimetable, PayProgram, DoctorOutsideTimetable


admin.site.register(Doctor)
admin.site.register(DoctorService)
admin.site.register(DoctorTimetable)
admin.site.register(DoctorOutsideTimetable)
admin.site.register(PayProgram)

