<?php
// �̻����
//$merchantaccount = 'YB01000000144';
//// �̻�˽Կ
//$merchantPrivateKey = 'MIICdQIBADANBgkqhkiG9w0BAQEFAASCAl8wggJbAgEAAoGBAPGE6DHyrUUAgqep/oGqMIsrJddJNFI1J/BL01zoTZ9+YiluJ7I3uYHtepApj+Jyc4Hfi+08CMSZBTHi5zWHlHQCl0WbdEkSxaiRX9t4aMS13WLYShKBjAZJdoLfYTGlyaw+tm7WG/MR+VWakkPX0pxfG+duZAQeIDoBLVfL++ihAgMBAAECgYAw2urBV862+5BybA/AmPWy4SqJbxR3YKtQj3YVACTbk4w1x0OeaGlNIAW/7bheXTqCVf8PISrA4hdL7RNKH7/mhxoX3sDuCO5nsI4Dj5xF24CymFaSRmvbiKU0Ylso2xAWDZqEs4Le/eDZKSy4LfXA17mxHpMBkzQffDMtiAGBpQJBAPn3mcAwZwzS4wjXldJ+Zoa5pwu1ZRH9fGNYkvhMTp9I9cf3wqJUN+fVPC6TIgLWyDf88XgFfjilNKNz0c/aGGcCQQD3WRxwots1lDcUhS4dpOYYnN3moKNgB07Hkpxkm+bw7xvjjHqI8q/4Jiou16eQURG+hlBZlZz37Y7P+PHF2XG3AkAyng/1WhfUAfRVewpsuIncaEXKWi4gSXthxrLkMteM68JRfvtb0cAMYyKvr72oY4Phyoe/LSWVJOcW3kIzW8+rAkBWekhQNRARBnXPbdS2to1f85A9btJP454udlrJbhxrBh4pC1dYBAlz59v9rpY+Ban/g7QZ7g4IPH0exzm4Y5K3AkBjEVxIKzb2sPDe34Aa6Qd/p6YpG9G6ND0afY+m5phBhH+rNkfYFkr98cBqjDm6NFhT7+CmRrF903gDQZmxCspY';
//// �̻���Կ
//$merchantPublicKey = 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDxhOgx8q1FAIKnqf6BqjCLKyXXSTRSNSfwS9Nc6E2ffmIpbieyN7mB7XqQKY/icnOB34vtPAjEmQUx4uc1h5R0ApdFm3RJEsWokV/beGjEtd1i2EoSgYwGSXaC32ExpcmsPrZu1hvzEflVmpJD19KcXxvnbmQEHiA6AS1Xy/vooQIDAQAB';
//// �ױ���Կ
//$yeepayPublicKey = 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCxnYJL7fH7DVsS920LOqCu8ZzebCc78MMGImzW8MaP/cmBGd57Cw7aRTmdJxFD6jj6lrSfprXIcT7ZXoGL5EYxWUTQGRsl4HZsr1AlaOKxT5UnsuEhA/K1dN1eA4lBpNCRHf9+XDlmqVBUguhNzy6nfNjb2aGE+hkxPP99I1iMlQIDAQAB';
//����Ϊ����ֵ

//����Ϊ��ʵ����
$merchantaccount = '10012432627';

$merchantPrivateKey = 'MIICdQIBADANBgkqhkiG9w0BAQEFAASCAl8wggJbAgEAAoGBAJp5EXHOInu5vxt21UnOnIWwejZs22R0xU79D45fEDR4RzuHqZtwaQRqvy3N0+zlTaPOREjmjeoKrpHhkLC0RGImV9i+kspr+bt5A+duS5wsIcG+aZMvlyzYyrzreTzEPrsSm99TfjIh+rn1K98q3aEjEaBdJzJZgj6/SdEqU37XAgMBAAECgYBwLtqPZt++MRBsNqoBdw5PPPIUkovmcbNVgQ0KHVnccTlyLzzqyQFLluaOsjtlgMYY31TSCLYpsWZERadZ3SEHcLP+7v+mSRuydNWQaYjaOvbh4Zo/sZA7IlYDWi7zH8N0rQ5nR02+MHmsfB3svrL61ha/2WEHKsc24U0DVxSuSQJBANoebiSM1LGH8cJXuwbMtvILjlQ8uSJrsm0Fvh0l4vFcj7OyZzgWnN4L4MjjFEKmuVyRTvDeX+P0Gxy6pwq4/bMCQQC1TPAO8rPZ4LcuV++hL7YSmzkC6fXgZdbCfWEgudR0ZHdpi5e2xiunMUwVwu7oqvLDhK43RcI4zlNEIY253BBNAkAB0g0zSuWfkbXn3FmYRe8k+Am5FESrT+DOXiTnE2DgiNg+NLf91Np8U/cNVi/eGowjhKb3BbQhL/Fl/PzV7xNXAkB8ttIj1jx10ijwTjle7c0Xe4N6R6qFlEhpPYpE0tAcyMeD6SyR5Dw/JKAsEA38KywX5vtYtjnmjbellFdD1Oe5AkAz3Fr+6GnJC1DLVIDHG7t2ey6QNJb2/o3XqubLhLsvyxv15I3sHrFeZWiPeYDkmYkVQKEgfNMi8biWeuWtxHW4';

$merchantPublicKey = 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCaeRFxziJ7ub8bdtVJzpyFsHo2bNtkdMVO/Q+OXxA0eEc7h6mbcGkEar8tzdPs5U2jzkRI5o3qCq6R4ZCwtERiJlfYvpLKa/m7eQPnbkucLCHBvmmTL5cs2Mq863k8xD67EpvfU34yIfq59SvfKt2hIxGgXScyWYI+v0nRKlN+1wIDAQAB';

$yeepayPublicKey = 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC6pjt4jkZcMj6zCxNn3lggfIniF9ayKfZ0rXW4gTvD8+YwZepLBSHjPPkNrCE6mUsy9yTaQrh+4rjhtCF9BfRS50JvJynNk1xaJhYSegK9ZDcVvRyslvtzMzVjTHpGgpUfoxBGIp4zp0p3PwzoJOKxhs3Q0MMvSr4IwWQpMfS55wIDAQAB';
?>