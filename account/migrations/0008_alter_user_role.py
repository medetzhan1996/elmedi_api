# Generated by Django 4.0.6 on 2023-03-20 09:43

from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('account', '0007_user_hospital'),
    ]

    operations = [
        migrations.AlterField(
            model_name='user',
            name='role',
            field=models.PositiveSmallIntegerField(choices=[(1, 'БАНК'), (2, 'КЛИЕНТ'), (3, 'Отчет')], default=1),
        ),
    ]
