SELECT t.VNO
    FROM BILL_DTL t
GROUP BY t.VNO
  HAVING COUNT(t.VNO) > 1