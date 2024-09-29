"use client"

import React from "react"
import { TrendingUp } from "lucide-react"
import { Area, AreaChart, CartesianGrid, XAxis, YAxis } from "recharts"
import DatePicker from "react-datepicker"
import "react-datepicker/dist/react-datepicker.css"
import { useForm } from "@inertiajs/react"

import {
  Card,
  CardContent,
  CardDescription,
  CardFooter,
  CardHeader,
  CardTitle,
} from "@/Components/ui/card"
import {
  ChartConfig,
  ChartContainer,
  ChartTooltip,
  ChartTooltipContent,
} from "@/Components/ui/chart"
import { Button } from "@/Components/ui/button"

type TicketSalesData = {
  month: string;
  totalSales: number;
}

type Props = {
  initialData: TicketSalesData[];
}

const chartConfig = {
  totalSales: {
    label: "Ticket Sales",
    color: "hsl(var(--chart-1))",
  },
} satisfies ChartConfig

export function TicketSalesChart({ initialData }: Props) {

  // console.log(initialData)
  const [chartData, setChartData] = React.useState<TicketSalesData[]>(initialData)

  console.log(chartData)

  const { data, setData, post, processing } = useForm({
    startDate: null as Date | null,
    endDate: null as Date | null,
  })

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault()
    post('/api/ticket-sales', {
      preserveState: true,
      preserveScroll: true,
      onSuccess: (page) => {
        // Type assertion to ensure the received data matches TicketSalesData[]
        const newData = page.props.ticketSalesData as TicketSalesData[];
        setChartData(newData);
      },
    })
  }

  return (
    <Card>
      <CardHeader>
        <CardTitle>Ticket Sales Chart</CardTitle>
        <CardDescription>
          Showing total ticket sales for the selected period
        </CardDescription>
      </CardHeader>
      <CardContent>
        <form onSubmit={handleSubmit} className="mb-4 flex items-end gap-4">
          <div>
            <label htmlFor="startDate" className="block text-sm font-medium text-gray-700">Start Date</label>
            <DatePicker
              id="startDate"
              selected={data.startDate}
              onChange={(date: Date | null) => setData('startDate', date)}
              className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
            />
          </div>
          <div>
            <label htmlFor="endDate" className="block text-sm font-medium text-gray-700">End Date</label>
            <DatePicker
              id="endDate"
              selected={data.endDate}
              onChange={(date: Date | null) => setData('endDate', date)}
              className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
            />
          </div>
          <Button type="submit" disabled={processing}>Update Chart</Button>
        </form>
        <ChartContainer config={chartConfig}>
          <AreaChart
            accessibilityLayer
            data={chartData}
            margin={{
              left: 12,
              right: 12,
              top: 20,
              bottom: 20,
            }}
          >
            <CartesianGrid vertical={false} />
            <XAxis
              dataKey="month"
              tickLine={false}
              axisLine={false}
              tickMargin={8}
              tickFormatter={(value) => value.slice(0, 3)}
            />
            <YAxis
              tickLine={false}
              axisLine={false}
              tickMargin={8}
              tickFormatter={(value) => `${value}`}
            />
            <ChartTooltip
              cursor={false}
              content={<ChartTooltipContent indicator="dot" hideLabel />}
            />
            <Area
              dataKey="totalSales"
              type="linear"
              fill="var(--color-totalSales)"
              fillOpacity={0.4}
              stroke="var(--color-totalSales)"
            />
          </AreaChart>
        </ChartContainer>
      </CardContent>
      <CardFooter>
        <div className="flex w-full items-start gap-2 text-sm">
          <div className="grid gap-2">
            <div className="flex items-center gap-2 font-medium leading-none">
              Trending up by 5.2% this period <TrendingUp className="h-4 w-4" />
            </div>
            <div className="flex items-center gap-2 leading-none text-muted-foreground">
              {chartData[0]?.month} - {chartData[chartData.length - 1]?.month}
            </div>
          </div>
        </div>
      </CardFooter>
    </Card>
  )
}
