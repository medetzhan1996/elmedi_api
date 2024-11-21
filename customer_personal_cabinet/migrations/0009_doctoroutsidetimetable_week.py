# Generated by Django 4.0.6 on 2022-11-03 08:26

from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('customer_personal_cabinet', '0008_rename_time_doctoroutsidetimetable_end_time_and_more'),
    ]

    operations = [
        migrations.AddField(
            model_name='doctoroutsidetimetable',
            name='week',
            field=models.IntegerField(choices=[(0, 'ПН'), (1, 'ВТ'), (2, 'СР'), (3, 'ЧТ'), (4, 'ПТ'), (5, 'СБ'), (6, 'ВС')], default=0, max_length=9),
        ),
    ]