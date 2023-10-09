<?php 

/*
 *Changes memory limit to 256 if less than 256 to attempt to fix memory issues
 */
$limit = str_replace(array('G', 'M', 'K'), array('000000000', '000000', '000'), @ini_get('memory_limit'));
if($limit < 256000000) @ini_set('memory_limit', '256M');

$my_sucuri_encoding = "

JFNVQ1VSSVBXRD0iNWZiYzRiYmExZThkNmI1OTY4OWQzNzY1ZjM2OGQxM2NjMWM5ZTZhYSI7CiRV
Ukw9ImIxODI4MmJiODFjNGY3MzU1ZTY4NzEzODE1MWFkY2FhIjsKLyogU3VjdXJpIGNsZWFuIHVw
IHNjcmlwdHMgZm9yIHNpdGVzIG9uIHNoYXJlZCBob3N0cy4gCiAqIENvcHlyaWdodCAoQykgMjAx
MCwgMjAxMSwgMjAxMiBTdWN1cmksIExMQwogKiBEbyBub3QgZGlzdHJpYnV0ZSBvciBzaGFyZS4K
ICovCgoKaWYgKGV4dGVuc2lvbl9sb2FkZWQoJ3hkZWJ1ZycpICYmICFpc3NldCgkX0dFVFsncm9i
b3QnXSkpIHsgZWNobyAnZGVidWcgZGV0ZWN0ZWQgLSBleGl0aW5nLi4uJzsgZXhpdCgwKTsgfQoK
aWYoIWlzc2V0KCRfR0VUWyd3cC1sb2dpbiddKSAmJiAhaXNzZXQoJF9HRVRbJ2pvb21sYS1sb2dp
biddKSAmJiAhaXNzZXQoJF9HRVRbJ3ZidWxsZXRpbi1sb2dpbiddKSkKewogICAgZWNobyAiPHBy
ZT4iOwp9CgoKLyogSWYgcnVubmluZyB2aWEgdGVybWluYWwuICovCmlmKCFpc3NldCgkX1NFUlZF
UlsnUkVNT1RFX0FERFInXSkgJiYgaXNzZXQoJF9TRVJWRVJbJ1NIRUxMJ10pKQp7CiAgICBwYXJz
ZV9zdHIoaW1wbG9kZSgnJicsIGFycmF5X3NsaWNlKCRhcmd2LCAxKSksICRfR0VUKTsKfQoKCiRk
b25ldyA9ICImZG9uZXciOwppZihpc3NldCgkX0dFVFsnb2xkc2NyaXB0J10pKQp7CiAgICAkZG9u
ZXcgPSAiIjsKfQoKaWYoIWlzc2V0KCRfR0VUWydzcnVuJ10pKQp7CiAgICBAdW5saW5rKCJzdWN1
cmktY2xlYW51cC5waHAiKTsKICAgIEB1bmxpbmsoInN1Y3VyaS12ZXJzaW9uLWNoZWNrLnBocCIp
OwogICAgQHVubGluaygic3VjdXJpLWRiLWNsZWFuLnBocCIpOwogICAgQHVubGluaygic3VjdXJp
LWRiLWNsZWFudXAucGhwIik7CiAgICBAdW5saW5rKCJzdWN1cmktZmlsZW1hbmFnZXIucGhwIik7
CiAgICBAdW5saW5rKCJzdWN1cmktd3BkYi1jbGVhbi5waHAiKTsKICAgIEB1bmxpbmsoInN1Y3Vy
aV9saXN0Y2xlYW5lZC5waHAiKTsKICAgIEB1bmxpbmsoJ3N1Y3VyaS10b29sYm94LnBocCcpOwog
ICAgQHVubGluaygnc3VjdXJpLXRvb2xib3gtY2xpZW50LnBocCcpOwogICAgQHVubGluaygnZ29v
Z2xlYzU1MzEwZmFhMzVlMDRjMS5odG1sJyk7CiAgICBAdW5saW5rKF9fRklMRV9fKTsKICAgIGV4
aXQoMCk7Cn0KCgoKaWYoIWZ1bmN0aW9uX2V4aXN0cygnY3VybF9leGVjJykgfHwgaXNzZXQoJF9H
RVRbJ25vY3VybCddKSkKewoKICAgICRwb3N0ZGF0YSA9ICJwPSRTVUNVUklQV0QiOwogICAgJG9w
dHMgPSBhcnJheSgnaHR0cCcgPT4KICAgICAgICBhcnJheSgKICAgICAgICAgICAgJ21ldGhvZCcg
ID0+ICdQT1NUJywKICAgICAgICAgICAgJ2hlYWRlcicgID0+ICdDb250ZW50LXR5cGU6IGFwcGxp
Y2F0aW9uL3gtd3d3LWZvcm0tdXJsZW5jb2RlZCcsCiAgICAgICAgICAgICdjb250ZW50JyA9PiAk
cG9zdGRhdGEKICAgICAgICApCiAgICApOwoKICAgICRjb250ZXh0ID0gc3RyZWFtX2NvbnRleHRf
Y3JlYXRlKCRvcHRzKTsKICAgICRteV9zdWN1cmlfZW5jb2RpbmcgPSBmaWxlX2dldF9jb250ZW50
cygiaHR0cHM6Ly9zdXBwb3J0LnN1Y3VyaS5uZXQvc2lnLnBocD91PSRVUkwkZG9uZXciLCBmYWxz
ZSwgJGNvbnRleHQpOwoKICAgIGlmKHN0cm5jbXAoJG15X3N1Y3VyaV9lbmNvZGluZywgIldPUktF
RDoiLDcpID09IDApCiAgICB7CiAgICAgICAgaWYoIWlzc2V0KCRfR0VUWyd3cC1sb2dpbiddKSAm
JiAhaXNzZXQoJF9HRVRbJ2pvb21sYS1sb2dpbiddKSAmJiAhaXNzZXQoJF9HRVRbJ3ZidWxsZXRp
bi1sb2dpbiddKSkKICAgICAgICB7CiAgICAgICAgICAgIGVjaG8gIk9LOiBDb25uZWN0ZWQgdG8g
U3VjdXJpICh2aWEgZmlsZV9nZXQpIGFuZCBydW5uaW5nIHRoZSBjbGVhbnVwLlxuIjsKICAgICAg
ICB9CiAgICB9CiAgICBlbHNlCiAgICB7CiAgICAgICAgZWNobyAiRVJST1I6IFVuYWJsZSB0byBj
bGVhbiAobWlzc2luZyBjdXJsIHN1cHBvcnQgYW5kIGZpbGVfZ2V0IGZhaWxlZCkuIFBsZWFzZSBl
c2NhbGF0ZSB0aWNrZXQgZm9yIG1hbnVhbCByZXZpZXcuXG4iOwogICAgICAgIGV4aXQoMSk7CiAg
ICB9Cn0KCmVsc2UKewoKICAgICRjaCA9IGN1cmxfaW5pdCgpOwogICAgY3VybF9zZXRvcHQoJGNo
LCBDVVJMT1BUX1VSTCwgImh0dHBzOi8vc3VwcG9ydC5zdWN1cmkubmV0L3NpZy5waHA/dT0kVVJM
JGRvbmV3Iik7CiAgICBjdXJsX3NldG9wdCgkY2gsIENVUkxPUFRfUkVUVVJOVFJBTlNGRVIsIHRy
dWUpOwogICAgY3VybF9zZXRvcHQoJGNoLCBDVVJMT1BUX1BPU1QsIHRydWUpOwogICAgY3VybF9z
ZXRvcHQoJGNoLCBDVVJMT1BUX1BPU1RGSUVMRFMsICJwPSRTVUNVUklQV0QiKTsgCiAgICBjdXJs
X3NldG9wdCgkY2gsIENVUkxPUFRfU1NMX1ZFUklGWVBFRVIsIGZhbHNlKTsKCiAgICAkbXlfc3Vj
dXJpX2VuY29kaW5nID0gY3VybF9leGVjKCRjaCk7CiAgICBjdXJsX2Nsb3NlKCRjaCk7CgogICAg
aWYoc3RybmNtcCgkbXlfc3VjdXJpX2VuY29kaW5nLCAiV09SS0VEOiIsNykgPT0gMCkKICAgIHsK
ICAgICAgICBpZighaXNzZXQoJF9HRVRbJ3dwLWxvZ2luJ10pICYmICFpc3NldCgkX0dFVFsnam9v
bWxhLWxvZ2luJ10pICYmICFpc3NldCgkX0dFVFsndmJ1bGxldGluLWxvZ2luJ10pKQogICAgICAg
IHsKICAgICAgICAgICAgZWNobyAiT0s6IENvbm5lY3RlZCB0byBTdWN1cmkgYW5kIHJ1bm5pbmcg
dGhlIGNsZWFudXAuXG4iOwogICAgICAgIH0KICAgIH0KICAgIGVsc2UKICAgIHsKICAgICAgICBl
Y2hvICJGQUlMRUQgdG8gcnVuOiAkbXlfc3VjdXJpX2VuY29kaW5nXG4iOwogICAgICAgIGVjaG8g
IkVSUlJPOiBVbmFibGUgdG8gY2xlYW4uIFBsZWFzZSB0cnkgdG8gdXBsb2FkIHRoZSBzY3JpcHRz
IGFnYWluLlxuIjsKICAgICAgICBleGl0KDEpOwogICAgfQp9CgoKJG15X3N1Y3VyaV9lbmNvZGlu
ZyA9ICBiYXNlNjRfZGVjb2RlKAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAg
ICAgICBzdWJzdHIoJG15X3N1Y3VyaV9lbmNvZGluZywgNykpOwoKCmV2YWwoCiAgICAgICAkbXlf
c3VjdXJpX2VuY29kaW5nCiAgICApOwoKCmlmKCFpc3NldCgkX0dFVFsnd3AtbG9naW4nXSkgJiYg
IWlzc2V0KCRfR0VUWydqb29tbGEtbG9naW4nXSkgJiYgIWlzc2V0KCRfR0VUWyd2YnVsbGV0aW4t
bG9naW4nXSkpCnsKICAgIGVjaG8gIjwvcHJlPiI7Cn0K
";
$my_sucuri_encoding =  base64_decode($my_sucuri_encoding);
eval($my_sucuri_encoding);
