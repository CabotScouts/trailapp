import React from 'react';
import List from '@/layouts/admin/submission-list';

export default function Submissions({ submissions }) {
  return (
    <List submissions={ submissions } />
  )
}
